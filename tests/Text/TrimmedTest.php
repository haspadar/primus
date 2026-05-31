<?php

declare(strict_types=1);

namespace Primus\Tests\Text;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Primus\Tests\Constraint\HasTextValue;
use Primus\Text\TextOf;
use Primus\Text\Trimmed;

/**
 */
final class TrimmedTest extends TestCase
{
    #[Test]
    public function returnsTextWithoutLeadingAndTrailingSpaces(): void
    {
        self::assertThat(
            new Trimmed(TextOf::str('  hello  world  ')),
            new HasTextValue('hello  world')
        );
    }

    #[Test]
    public function returnsEmptyStringWhenInputIsWhitespaceOnly(): void
    {
        self::assertThat(
            new Trimmed(TextOf::str('   ')),
            new HasTextValue('')
        );
    }

    #[Test]
    public function ofTextFactoryAgreesWithPrimaryConstructor(): void
    {
        $source = TextOf::str(' hello ');

        self::assertSame(
            (new Trimmed($source))->value(),
            Trimmed::ofText($source)->value(),
        );
    }

    #[Test]
    public function ofStringFactoryAgreesWithPrimaryConstructor(): void
    {
        self::assertSame(
            (new Trimmed(TextOf::str(' hello ')))->value(),
            Trimmed::ofString(' hello ')->value(),
        );
    }
}
