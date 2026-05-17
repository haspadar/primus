<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\Replaced;
use Primus\Text\TextOf;

/**
 */
final class ReplacedTest extends TestCase
{
    #[Test]
    public function replacesSingleSubstring(): void
    {
        self::assertThat(
            new Replaced(TextOf::str('Hello, world!'), 'world', 'friend'),
            new HasTextValue('Hello, friend!')
        );
    }

    #[Test]
    public function replacesMultipleSubstrings(): void
    {
        self::assertThat(
            new Replaced(
                TextOf::str('<b>Hello & bye</b>'),
                ['<b>', '</b>', '&'],
                ['', '', 'and']
            ),
            new HasTextValue('Hello and bye')
        );
    }

    #[Test]
    public function returnsOriginalTextWhenNoMatches(): void
    {
        self::assertThat(
            new Replaced(TextOf::str('unchanged'), 'zzz', 'xxx'),
            new HasTextValue('unchanged')
        );
    }

    #[Test]
    public function handlesEmptyText(): void
    {
        self::assertThat(
            new Replaced(TextOf::str(''), 'a', 'b'),
            new HasTextValue('')
        );
    }
}
