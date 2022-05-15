<?php

declare(strict_types=1);

namespace Ghostwriter\result\Tests\Unit;

use Ghostwriter\result\Foo;

/**
 * @coversDefaultClass \Ghostwriter\result\Foo
 *
 * @internal
 *
 * @small
 */
final class FooTest extends AbstractTestCase
{
    /** @covers ::test */
    public function test(): void
    {
        self::assertTrue((new Foo())->test());
    }
}
