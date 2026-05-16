<?php

return [
    'complexity' => [
        'max_cyclomatic_per_method' => 10,
        'max_weighted_methods_per_class' => 20,
    ],
    'size' => [
        'max_loc_per_class' => 1000,
        'max_logical_loc_per_class' => 600,
        'max_logical_loc_per_method' => 20,
    ],
    'halstead' => [
        'max_volume_per_method' => 1000,
        'max_difficulty_per_method' => 15,
        'max_effort_per_method' => 15000,
        'max_bugs_per_method' => 0.5,
    ],
    'inheritance' => [
        'max_depth' => 3,
    ],
    'structure' => [
        'max_methods_per_class' => 10,
    ],
    'coupling' => [
        'max_afferent' => 30,
        'max_efferent' => 10,
    ],
];
