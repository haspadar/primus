<?php

declare(strict_types=1);

namespace Primus\Tests\Map;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Map\MapOf;
use Primus\Map\Values;

final class ValuesTest extends TestCase
{
    #[Test]
    public function exposesValuesOfEmptyMapAsEmptyList(): void
    {
        $this->assertSame([], (new Values(new MapOf([])))->value());
    }

    #[Test]
    public function exposesValuesInSourceOrder(): void
    {
        $this->assertSame(
            [1, 2, 3],
            (new Values(new MapOf(['a' => 1, 'b' => 2, 'c' => 3])))->value(),
        );
    }

    #[Test]
    public function preservesValuesRegardlessOfKeyTypes(): void
    {
        $this->assertSame(
            ['first', 'Alice', 'leadingZero', 'lucky'],
            (new Values(new MapOf([
                0 => 'first',
                'name' => 'Alice',
                '01' => 'leadingZero',
                7 => 'lucky',
            ])))->value(),
        );
    }

    #[Test]
    public function preservesDuplicateValues(): void
    {
        $this->assertSame(
            [1, 1, 2],
            (new Values(new MapOf(['a' => 1, 'b' => 1, 'c' => 2])))->value(),
        );
    }

    #[Test]
    public function iteratorYieldsSameSequenceAsValue(): void
    {
        $values = new Values(new MapOf(['x' => 1, 'y' => 2]));
        $this->assertSame(
            $values->value(),
            iterator_to_array($values),
        );
    }

    #[Test]
    public function countsAsManyAsPairsInSource(): void
    {
        $this->assertCount(
            3,
            new Values(new MapOf(['a' => 1, 'b' => 2, 'c' => 3])),
        );
    }

    #[Test]
    public function leavesSourceUntouchedAfterReading(): void
    {
        $source = new MapOf(['a' => 1, 'b' => 2]);
        $values = new Values($source);
        $values->value();
        iterator_to_array($values);
        $this->assertSame(['a' => 1, 'b' => 2], $source->value());
    }
}
