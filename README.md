# PHP CS Fixer: custom fixers

[![Latest stable version](https://img.shields.io/packagist/v/kubawerlos/php-cs-fixer-custom-fixers.svg?label=current%20version)](https://packagist.org/packages/kubawerlos/php-cs-fixer-custom-fixers)
[![PHP version](https://img.shields.io/packagist/php-v/kubawerlos/php-cs-fixer-custom-fixers.svg)](https://php.net)
[![License](https://img.shields.io/github/license/kubawerlos/php-cs-fixer-custom-fixers.svg)](LICENSE)
![Tests](https://img.shields.io/badge/tests-2790-brightgreen.svg)
[![Downloads](https://img.shields.io/packagist/dt/kubawerlos/php-cs-fixer-custom-fixers.svg)](https://packagist.org/packages/kubawerlos/php-cs-fixer-custom-fixers)

[![CI Status](https://github.com/kubawerlos/php-cs-fixer-custom-fixers/workflows/CI/badge.svg?branch=main&event=push)](https://github.com/kubawerlos/php-cs-fixer-custom-fixers/actions)
[![Code coverage](https://img.shields.io/coveralls/github/kubawerlos/php-cs-fixer-custom-fixers/main.svg)](https://coveralls.io/github/kubawerlos/php-cs-fixer-custom-fixers?branch=main)
[![Mutation testing badge](https://badge.stryker-mutator.io/github.com/kubawerlos/php-cs-fixer-custom-fixers/main)](https://stryker-mutator.github.io)
[![Psalm type coverage](https://shepherd.dev/github/kubawerlos/php-cs-fixer-custom-fixers/coverage.svg)](https://shepherd.dev/github/kubawerlos/php-cs-fixer-custom-fixers)

A set of custom fixers for [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer).

## Installation
PHP CS Fixer: custom fixers can be installed by running:
```bash
composer require --dev kubawerlos/php-cs-fixer-custom-fixers
```


## Usage
In your PHP CS Fixer configuration register fixers and use them:
```diff
 <?php
 return PhpCsFixer\Config::create()
+    ->registerCustomFixers(new PhpCsFixerCustomFixers\Fixers())
     ->setRules([
         '@PSR2' => true,
         'array_syntax' => ['syntax' => 'short'],
+        PhpCsFixerCustomFixers\Fixer\NoLeadingSlashInGlobalNamespaceFixer::name() => true,
+        PhpCsFixerCustomFixers\Fixer\PhpdocNoSuperfluousParamFixer::name() => true,
     ]);
```


## Fixers
#### CommentSurroundedBySpacesFixer
Comment must be surrounded by spaces.
```diff
 <?php
-/*foo*/
+/* foo */
```

#### CommentedOutFunctionFixer
Configured functions must be commented out.
  *Risky: when any of the configured functions has side effects or is overridden.*
Configuration options:
- `functions` (`array`): list of functions to comment out; defaults to `['print_r', 'var_dump', 'var_export']`
```diff
 <?php
-var_dump($x);
+//var_dump($x);
```

#### DataProviderNameFixer
Name of data provider that is used only once must match name of test.
  *Risky: when relying on name of data provider function.*
Configuration options:
- `prefix` (`string`): prefix that replaces "test"; defaults to `'provide'`
- `suffix` (`string`): suffix to be added at the end"; defaults to `'Cases'`
```diff
 <?php
 class FooTest extends TestCase {
     /**
-     * @dataProvider dataProvider
+     * @dataProvider provideHappyPathCases
      */
     public function testHappyPath() {}
-    public function dataProvider() {}
+    public function provideHappyPathCases() {}
 }
```

#### DataProviderReturnTypeFixer
Return type of data provider must be `iterable`.
  *Risky: when relying on signature of data provider.*
```diff
 <?php
 class FooTest extends TestCase {
     /**
      * @dataProvider provideHappyPathCases
      */
     public function testHappyPath() {}
-    public function provideHappyPathCases(): array {}
+    public function provideHappyPathCases(): iterable {}
 }
```

#### DataProviderStaticFixer
Data provider must be static.
```diff
 <?php
 class FooTest extends TestCase {
     /**
      * @dataProvider provideHappyPathCases
      */
     public function testHappyPath() {}
-    public function provideHappyPathCases() {}
+    public static function provideHappyPathCases() {}
 }
```

#### InternalClassCasingFixer
Class defined internally by an extension, or the core should be called using the correct casing.
```diff
 <?php
-$foo = new STDClass();
+$foo = new stdClass();
```

#### MultilineCommentOpeningClosingAloneFixer
Multiline comment/PHPDoc must have opening and closing line without any extra content.
```diff
 <?php
-/** Hello
+/**
+ * Hello
  * World!
  */;
```

#### NoCommentedOutCodeFixer
There should be no commented out code.
```diff
 <?php
-//var_dump($_POST);
 print_r($_POST);
```

#### NoDoctrineMigrationsGeneratedCommentFixer
There must be no comment generated by Doctrine Migrations.
```diff
 <?php
 namespace Migrations;
 use Doctrine\DBAL\Schema\Schema;
-/**
- * Auto-generated Migration: Please modify to your needs!
- */
 final class Version20180609123456 extends AbstractMigration
 {
     public function up(Schema $schema)
     {
-        // this up() migration is auto-generated, please modify it to your needs
         $this->addSql("UPDATE t1 SET col1 = col1 + 1");
     }
     public function down(Schema $schema)
     {
-        // this down() migration is auto-generated, please modify it to your needs
         $this->addSql("UPDATE t1 SET col1 = col1 - 1");
     }
 }
```

#### NoDuplicatedArrayKeyFixer
Duplicated array keys must be removed.
```diff
 <?php
 $x = [
-    "foo" => 1,
     "bar" => 2,
     "foo" => 3,
 ];
```

#### NoDuplicatedImportsFixer
Duplicated `use` statements must be removed.
```diff
 <?php
 namespace FooBar;
 use Foo;
-use Foo;
 use Bar;
```

#### NoImportFromGlobalNamespaceFixer
There must be no import from global namespace.
```diff
 <?php
 namespace Foo;
-use DateTime;
 class Bar {
-    public function __construct(DateTime $dateTime) {}
+    public function __construct(\DateTime $dateTime) {}
 }
```

#### NoLeadingSlashInGlobalNamespaceFixer
When in global namespace there must be no leading slash for class.
```diff
 <?php
-$x = new \Foo();
+$x = new Foo();
 namespace Bar;
 $y = new \Baz();
```

#### NoNullableBooleanTypeFixer
There must be no nullable boolean type.
  *Risky: when the null is used.*
```diff
 <?php
-function foo(?bool $bar) : ?bool
+function foo(bool $bar) : bool
 {
      return $bar;
  }
```

#### NoPhpStormGeneratedCommentFixer
There must be no comment generated by PhpStorm.
```diff
 <?php
-/**
- * Created by PhpStorm.
- * User: root
- * Date: 01.01.70
- * Time: 12:00
- */
 namespace Foo;
```

#### NoReferenceInFunctionDefinitionFixer
There must be no reference in function definition.
  *Risky: when rely on reference.*
```diff
 <?php
-function foo(&$x) {}
+function foo($x) {}
```

#### NoSuperfluousConcatenationFixer
There should not be superfluous inline concatenation of strings.
Configuration options:
- `allow_preventing_trailing_spaces` (`bool`): whether to keep concatenation if it prevents having trailing spaces in string; defaults to `false`
```diff
 <?php
-echo 'foo' . 'bar';
+echo 'foobar';
```

#### NoUselessCommentFixer
There must be no comment like "Class Foo".
```diff
 <?php
 /**
- * Class Foo
  * Class to do something
  */
 class Foo {
     /**
-     * Get bar
      */
     function getBar() {}
 }
```

#### NoUselessDoctrineRepositoryCommentFixer
There must be no comment generated by the Doctrine ORM.
```diff
 <?php
-/**
- * FooRepository
- *
- * This class was generated by the Doctrine ORM. Add your own custom
- * repository methods below.
- */
 class FooRepository extends EntityRepository {}
```

#### NoUselessParenthesisFixer
There must be no useless parenthesis.
```diff
 <?php
-foo(($bar));
+foo($bar);
```

#### NoUselessSprintfFixer
Function `sprintf` without parameters should not be used.
  DEPRECATED: use `no_useless_sprintf` instead.
  *Risky: when the function `sprintf` is overridden.*
```diff
 <?php
-$foo = sprintf('Foo');
+$foo = 'Foo';
```

#### NoUselessStrlenFixer
Function `strlen` (or `mb_strlen`) should not be used when compared to 0.
  *Risky: when the function `strlen` is overridden.*
```diff
 <?php
-$isEmpty = strlen($string) === 0;
-$isNotEmpty = strlen($string) > 0;
+$isEmpty = $string === '';
+$isNotEmpty = $string !== '';
```

#### NumericLiteralSeparatorFixer
Numeric literals must have configured separators.
Configuration options:
- `binary` (`bool`, `null`): whether add, remove or ignore separators in binary numbers.; defaults to `false`
- `decimal` (`bool`, `null`): whether add, remove or ignore separators in decimal numbers.; defaults to `false`
- `float` (`bool`, `null`): whether add, remove or ignore separators in float numbers.; defaults to `false`
- `hexadecimal` (`bool`, `null`): whether add, remove or ignore separators in hexadecimal numbers.; defaults to `false`
- `octal` (`bool`, `null`): whether add, remove or ignore separators in octal numbers.; defaults to `false`
```diff
 <?php
-echo 0b01010100_01101000; // binary
-echo 135_798_642; // decimal
-echo 1_234.456_78e-4_321; // float
-echo 0xAE_B0_42_FC; // hexadecimal
-echo 0123_4567; // octal
+echo 0b0101010001101000; // binary
+echo 135798642; // decimal
+echo 1234.45678e-4321; // float
+echo 0xAEB042FC; // hexadecimal
+echo 01234567; // octal
```

#### OperatorLinebreakFixer
Operators - when multiline - must always be at the beginning or at the end of the line.
  DEPRECATED: use `operator_linebreak` instead.
Configuration options:
- `only_booleans` (`bool`): whether to limit operators to only boolean ones; defaults to `false`
- `position` (`'beginning'`, `'end'`): whether to place operators at the beginning or at the end of the line; defaults to `'beginning'`
```diff
 <?php
 function foo() {
-    return $bar ||
-        $baz;
+    return $bar
+        || $baz;
 }
```

#### PhpUnitNoUselessReturnFixer
PHPUnit's functions `fail`, `markTestIncomplete` and `markTestSkipped` should not be followed directly by return.
  *Risky: when PHPUnit's native methods are overridden.*
```diff
 <?php
 class FooTest extends TestCase {
     public function testFoo() {
         $this->markTestSkipped();
-        return;
     }
 }
```

#### PhpdocNoIncorrectVarAnnotationFixer
`@var` must be correct in the code.
```diff
 <?php
-/** @var Foo $foo */
 $bar = new Foo();
```

#### PhpdocNoSuperfluousParamFixer
There must be no superfluous parameters in PHPDoc.
```diff
 <?php
 /**
  * @param bool $b
- * @param int $i
  * @param string $s this is string
- * @param string $s duplicated
  */
 function foo($b, $s) {}
```

#### PhpdocOnlyAllowedAnnotationsFixer
Only listed annotations can be in PHPDoc.
Configuration options:
- `elements` (`array`): list of annotations to keep in PHPDoc; defaults to `[]`
```diff
 <?php
 /**
  * @author John Doe
- * @package foo
- * @subpackage bar
  * @version 1.0
  */
 function foo_bar() {}
```

#### PhpdocParamOrderFixer
`@param` annotations must be in the same order as function's parameters.
```diff
 <?php
 /**
+ * @param int $a
  * @param int $b
- * @param int $a
  * @param int $c
  */
 function foo($a, $b, $c) {}
```

#### PhpdocParamTypeFixer
`@param` must have type.
```diff
 <?php
 /**
  * @param string $foo
- * @param        $bar
+ * @param mixed  $bar
  */
 function a($foo, $bar) {}
```

#### PhpdocSelfAccessorFixer
In PHPDoc inside class or interface element `self` should be preferred over the class name itself.
```diff
 <?php
 class Foo {
     /**
-     * @var Foo
+     * @var self
      */
      private $instance;
 }
```

#### PhpdocSingleLineVarFixer
`@var` annotation must be in single line when is the only content.
```diff
 <?php
 class Foo {
-    /**
-     * @var string
-     */
+    /** @var string */
     private $name;
 }
```

#### PhpdocTypesTrimFixer
PHPDoc types must be trimmed.
```diff
 <?php
 /**
- * @param null | string $x
+ * @param null|string $x
  */
 function foo($x) {}
```

#### SingleSpaceAfterStatementFixer
Single space must follow - not followed by semicolon - statement.
Configuration options:
- `allow_linebreak` (`bool`): whether to allow statement followed by linebreak; defaults to `false`
```diff
 <?php
-$foo = new    Foo();
-echo$foo->__toString();
+$foo = new Foo();
+echo $foo->__toString();
```

#### SingleSpaceBeforeStatementFixer
Single space must precede - not preceded by linebreak - statement.
```diff
 <?php
-$foo =new Foo();
+$foo = new Foo();
```


## Contributing
Request feature or report bug by creating [issue](https://github.com/kubawerlos/php-cs-fixer-custom-fixers/issues).

Alternatively, fork the repo, develop your changes, regenerate `README.md`:
```bash
php ./dev-tools/readme > ./README.md
```
make sure all checks pass:
```bash
./dev-tools/check_file_permissions.sh
./dev-tools/check_trailing_whitespaces.sh
composer verify
composer infection
```
and submit pull request.
