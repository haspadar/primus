<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\HtmlEscaped;
use Primus\Text\TextOf;

/**
 */
final class HtmlEscapedTest extends TestCase
{
    #[Test]
    public function escapesSpecialCharacters(): void
    {
        self::assertThat(
            new HtmlEscaped(TextOf::str('<b>John & "Jane"</b>')),
            new HasTextValue('&lt;b&gt;John &amp; &quot;Jane&quot;&lt;/b&gt;')
        );
    }

    #[Test]
    public function leavesPlainTextUntouched(): void
    {
        self::assertThat(
            new HtmlEscaped(TextOf::str('Hello world')),
            new HasTextValue('Hello world')
        );
    }

    #[Test]
    public function handlesEmptyString(): void
    {
        self::assertThat(
            new HtmlEscaped(TextOf::str('')),
            new HasTextValue('')
        );
    }
}
