<?php

declare(strict_types=1);

namespace Primus\Tests\List;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\List\Contains;
use Primus\List\ListOf;

final class ContainsTest extends TestCase
{
    #[Test]
    public function returnsTrueWhenStrictMatchExists(): void
    {
        $this->assertTrue(
            (new Contains(new ListOf(1, 2, 3), 2))->value(),
        );
    }

    #[Test]
    public function returnsFalseWhenNoMatchExists(): void
    {
        $this->assertFalse(
            (new Contains(new ListOf(1, 2, 3), 4))->value(),
        );
    }

    #[Test]
    public function returnsFalseForEmptyList(): void
    {
        $this->assertFalse(
            (new Contains(new ListOf(), 'anything'))->value(),
        );
    }

    #[Test]
    public function distinguishesValuesByStrictType(): void
    {
        $this->assertFalse(
            (new Contains(new ListOf(0, '1', false), 1))->value(),
        );
    }

    #[Test]
    public function findsStringValueByStrictMatch(): void
    {
        $this->assertTrue(
            (new Contains(new ListOf('a', 'b', 'c'), 'b'))->value(),
        );
    }

    #[Test]
    public function findsObjectByIdentity(): void
    {
        $object = new \stdClass();
        $this->assertTrue(
            (new Contains(new ListOf(new \stdClass(), $object), $object))->value(),
        );
    }
}
