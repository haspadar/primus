<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Func\BiFuncOf;
use Primus\Func\FuncOf;
use Primus\Map\BiMapped;
use Primus\Map\Filtered;
use Primus\Map\MapOf;

final class BiMappedTest extends TestCase
{
    #[Test]
    public function transformsEachValueWithItsKey(): void
    {
        $this->assertSame(
            ['name' => 'name:Ada', 'role' => 'role:admin'],
            (new BiMapped(
                new MapOf(['name' => 'Ada', 'role' => 'admin']),
                new BiFuncOf(static fn (string $key, string $value): string => "$key:$value"),
            ))->value(),
        );
    }

    #[Test]
    public function preservesCount(): void
    {
        $this->assertCount(
            3,
            new BiMapped(
                new MapOf(['low' => 1, 'mid' => 5, 'high' => 9]),
                new BiFuncOf(static fn (string $key, int $value): string => "$key=$value"),
            ),
        );
    }

    #[Test]
    public function iteratesOverTransformedPairs(): void
    {
        $collected = [];
        foreach (
            new BiMapped(
                new MapOf(['draft' => 2, 'done' => 7]),
                new BiFuncOf(static fn (string $key, int $value): string => "$key:$value"),
            ) as $key => $value
        ) {
            $collected[$key] = $value;
        }
        $this->assertSame(['draft' => 'draft:2', 'done' => 'done:7'], $collected);
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new MapOf(['city' => 'Minsk', 'river' => 'Svislach']);
        $mapped = new BiMapped(
            $source,
            new BiFuncOf(static fn (string $key, string $value): string => "$key=$value"),
        );
        $mapped->value();
        iterator_to_array($mapped);
        $this->assertSame(['city' => 'Minsk', 'river' => 'Svislach'], $source->value());
    }

    #[Test]
    public function composesWithFiltered(): void
    {
        $this->assertSame(
            ['urgent' => 'urgent:8'],
            (new BiMapped(
                new Filtered(
                    new MapOf(['later' => 3, 'urgent' => 8]),
                    new FuncOf(static fn (int $value): bool => $value > 5),
                ),
                new BiFuncOf(static fn (string $key, int $value): string => "$key:$value"),
            ))->value(),
        );
    }

    #[Test]
    public function yieldsEmptyWhenSourceIsEmpty(): void
    {
        $this->assertCount(
            0,
            new BiMapped(
                new MapOf([]),
                new BiFuncOf(static fn (string $key, int $value): string => "$key:$value"),
            ),
        );
    }
}
