<?php declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer: custom fixers.
 *
 * (c) 2018 Kuba Werłos
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Fixer;

/**
 * @internal
 *
 * @covers \PhpCsFixerCustomFixers\Fixer\NoPhpStormGeneratedCommentFixer
 */
final class NoPhpStormGeneratedCommentFixerTest extends AbstractFixerTestCase
{
    public function testIsRisky(): void
    {
        self::assertRiskiness(false);
    }

    /**
     * @dataProvider provideFixCases
     */
    public function testFix(string $expected, ?string $input = null): void
    {
        $this->doTest($expected, $input);
    }

    /**
     * @return iterable<array{0: string, 1?: string}>
     */
    public static function provideFixCases(): iterable
    {
        yield [
            '<?php
namespace Foo;
',
            '<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01.01.70
 * Time: 12:34
 */
namespace Foo;
',
        ];

        yield [
            '<?php
namespace Foo;
',
            '<?php
/*
 * Created by PhpStorm.
 * User: root
 * Date: 01.01.70
 * Time: 12:34
 */
namespace Foo;
',
        ];

        yield [
            '<?php
namespace Foo;
/** class Bar */
class Bar {}
',
            '<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 01.01.70
 * Time: 12:34
 */
namespace Foo;
/** class Bar */
class Bar {}
',
        ];

        yield [
            '<?php

namespace Foo;
',
            '<?php

/**
 * Created by PHPStorm.
 */
namespace Foo;
',
        ];

        yield [
            '<?php

namespace Foo;
',
            '<?php
/**
 * Created by PHPStorm.
 */

namespace Foo;
',
        ];

        yield [
            '<?php


    namespace Foo;
',
            '<?php

    /**
     * Created by PHPStorm.
     */

    namespace Foo;
',
        ];

        yield [
            '<?php
                namespace Foo;
',
            '<?php
                /**
                 * Created by PHPStorm.
                 */
                namespace Foo;
',
        ];

        yield [
            '<?php
namespace Foo;
',
            '<?php
/** Created by PhpStorm */namespace Foo;
',
        ];

        yield [
            '<?php
    namespace Foo;
',
            '<?php
/** Created by PhpStorm */    namespace Foo;
',
        ];

        yield [
            '<?php
/**
 * Created by not PhpStorm.
 */
namespace Foo;
',
        ];

        yield [
            <<<'PHP'
                <?php
                $foo = 2;
                PHP,
            <<<'PHP'
                <?php
                /**
                 * Created by JetBrains PhpStorm.
                 * User: john
                 * Date: 1/1/11
                 * Time: 11:11 AM
                 */
                $foo = 2;
                PHP,
        ];
    }
}
