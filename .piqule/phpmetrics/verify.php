#!/usr/bin/env php
<?php

declare(strict_types=1);

$config = require __DIR__ . '/rules.php';
$report = json_decode(
    file_get_contents(__DIR__ . '/phpmetrics.json'),
    true,
    flags: JSON_THROW_ON_ERROR,
);

$violations = analyzeReport($report, $config);

if ($violations !== []) {
    renderViolationsGrouped($violations);
    exit(1);
}

echo "✔ phpmetrics passed all thresholds\n";

function analyzeReport(array $report, array $config): array
{
    $violations = [];

    foreach ($report as $node) {
        if (($node['_type'] ?? null) === 'Hal\\Metric\\ClassMetric') {
            foreach (analyzeClass($node, $config) as $v) {
                $violations[] = $v;
            }
        }

        if (($node['_type'] ?? null) === 'Hal\\Metric\\ProjectMetric') {
            foreach (analyzeProject($node, $config) as $v) {
                $violations[] = $v;
            }
        }
    }

    return $violations;
}

function analyzeClass(array $node, array $config): array
{
    $violations = [];
    $class = $node['name'];

    foreach (classRules() as $r) {
        $limit = rule($config, $r['rule']);
        if ($limit === null) {
            continue;
        }

        $actual = $node[$r['metric']] ?? null;
        if ($actual === null) {
            continue;
        }

        $items = $r['type'] === 'min'
            ? checkMin($class, $r['label'], $actual, $limit, path($r['rule']))
            : checkMax($class, $r['label'], $actual, $limit, path($r['rule']));

        foreach ($items as $v) {
            $violations[] = $v;
        }
    }

    foreach ($node['methods'] ?? [] as $method) {
        foreach (analyzeMethod($class, $method, $config) as $v) {
            $violations[] = $v;
        }
    }

    return $violations;
}

function analyzeMethod(string $class, array $method, array $config): array
{
    $violations = [];
    $name = $method['name'];

    foreach (methodRules() as $r) {
        $limit = rule($config, $r['rule']);
        if ($limit === null) {
            continue;
        }

        foreach (
            checkMax(
                $class,
                "Method {$name} {$r['label']}",
                $method[$r['metric']] ?? 0,
                $limit,
                path($r['rule']),
            ) as $v
        ) {
            $violations[] = $v;
        }
    }

    return $violations;
}

function analyzeProject(array $node, array $config): array
{
    if ($node['name'] !== 'tree') {
        return [];
    }

    $maxDepth = rule($config, ['inheritance', 'max_depth']);
    if ($maxDepth === null) {
        return [];
    }

    if ($node['depthOfInheritanceTree'] > $maxDepth) {
        return [[
            'class'   => 'Project',
            'message' => "Inheritance depth too high: got {$node['depthOfInheritanceTree']} (max: $maxDepth)",
            'rule'    => 'inheritance.max_depth',
        ]];
    }

    return [];
}

function classRules(): array
{
    return [
        ['label' => 'Maintainability', 'metric' => 'mi', 'rule' => ['maintainability', 'min_index'], 'type' => 'min'],
        ['label' => 'WMC', 'metric' => 'wmc', 'rule' => ['complexity', 'max_weighted_methods_per_class'], 'type' => 'max'],
        ['label' => 'Cyclomatic complexity', 'metric' => 'ccnMethodMax', 'rule' => ['complexity', 'max_cyclomatic_per_method'], 'type' => 'max'],
        ['label' => 'LOC', 'metric' => 'loc', 'rule' => ['size', 'max_loc_per_class'], 'type' => 'max'],
        ['label' => 'LLOC', 'metric' => 'lloc', 'rule' => ['size', 'max_logical_loc_per_class'], 'type' => 'max'],
        ['label' => 'Methods count', 'metric' => 'nbMethods', 'rule' => ['structure', 'max_methods_per_class'], 'type' => 'max'],
        ['label' => 'Afferent coupling', 'metric' => 'afferentCoupling', 'rule' => ['coupling', 'max_afferent'], 'type' => 'max'],
        ['label' => 'Efferent coupling', 'metric' => 'efferentCoupling', 'rule' => ['coupling', 'max_efferent'], 'type' => 'max'],
        ['label' => 'Instability', 'metric' => 'instability', 'rule' => ['coupling', 'max_instability'], 'type' => 'max'],
    ];
}

function methodRules(): array
{
    return [
        ['label' => 'LLOC', 'metric' => 'lloc', 'rule' => ['size', 'max_logical_loc_per_method']],
        ['label' => 'volume', 'metric' => 'volume', 'rule' => ['halstead', 'max_volume_per_method']],
        ['label' => 'difficulty', 'metric' => 'difficulty', 'rule' => ['halstead', 'max_difficulty_per_method']],
        ['label' => 'effort', 'metric' => 'effort', 'rule' => ['halstead', 'max_effort_per_method']],
        ['label' => 'bugs', 'metric' => 'bugs', 'rule' => ['halstead', 'max_bugs_per_method']],
    ];
}

function rule(array $config, array $path): mixed
{
    foreach ($path as $key) {
        if (!array_key_exists($key, $config)) {
            return null;
        }
        $config = $config[$key];
    }

    return $config;
}

function path(array $rule): string
{
    return implode('.', $rule);
}

function checkMax(
    string $class,
    string $label,
    int|float $actual,
    int|float|null $max,
    string $rule,
): array {
    if ($max === null || $actual <= $max) {
        return [];
    }

    return [[
        'class'   => $class,
        'message' => "$label too high: got $actual (max: $max)",
        'rule'    => $rule,
    ]];
}

function checkMin(
    string $class,
    string $label,
    int|float|null $actual,
    int|float|null $min,
    string $rule,
): array {
    if ($actual === null || $min === null || $actual >= $min) {
        return [];
    }

    return [[
        'class'   => $class,
        'message' => "$label too low: got $actual (min: $min)",
        'rule'    => $rule,
    ]];
}

function renderViolationsGrouped(array $violations): void
{
    $byClass = [];

    foreach ($violations as $v) {
        $byClass[$v['class']][] = $v;
    }

    ksort($byClass);

    foreach ($byClass as $class => $items) {
        fwrite(STDERR, "\nClass: $class\n");
        foreach ($items as $v) {
            fwrite(STDERR, " • {$v['message']} #{$v['rule']}\n");
        }
    }

    fwrite(STDERR, "\n");
}
