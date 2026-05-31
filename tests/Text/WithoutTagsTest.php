<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\TextOf;
use Primus\Text\WithoutTags;

/**
 */
final class WithoutTagsTest extends TestCase
{
    #[Test]
    public function returnsSanitizedTextWhenHtmlTagsArePresent(): void
    {
        self::assertThat(
            new WithoutTags(TextOf::str('<script>alert("XSS")</script><b>bold</b> & "quote"')),
            new HasTextValue('alert("XSS")bold & "quote"')
        );
    }

    #[Test]
    public function returnsSameTextWhenInputIsPlain(): void
    {
        self::assertThat(
            new WithoutTags(TextOf::str('safe text 123')),
            new HasTextValue('safe text 123')
        );
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str('<b>A & B</b>');

        self::assertSame(
            (new WithoutTags($source))->value(),
            WithoutTags::ofText($source)->value(),
        );
    }

    #[Test]
    public function ofStringFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new WithoutTags(TextOf::str('<b>A & B</b>')))->value(),
            WithoutTags::ofString('<b>A & B</b>')->value(),
        );
    }
}
