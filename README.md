# phpunit-xpath-assertions

[![Build Status](https://img.shields.io/travis/ThomasWeinert/phpunit-xpath-assertions.svg)](https://travis-ci.org/ThomasWeinert/phpunit-xpath-assertions)

Xpath assertions and constraints for use with PHPUnit. 

## Example

```php
use PHPUnit\Framework\TestCase;
use PHPUnit\Xpath\Assert as XpathAssertions;

class MyProjectExampleTest extends TestCase
{
    use XpathAssertions;

    public function testChildElementExistsInDocument()
    {
        $document = new \DOMDocument();
        $document->loadXML('<root><child>TEXT</child></root>');

        self::assertXpathMatch('//child', $document);
    }

    public function testCompareChildElementFromDocument()
    {
        $document = new \DOMDocument();
        $document->loadXML('<root><child>TEXT</child></root>');

        self::assertXpathEquals('<child>TEXT</child>', '//child', $document);
    }
}
```

## Installation

### Composer

If you use [Composer](https://getcomposer.org/) to manage the dependencies of your project then you can add the PHPUnit example extension as a development-time dependency to your project:

```
$ composer require --dev thomasweinert/phpunit-xpath-assertions
```

The library provides traits that you can use to add the assertions to your TestCase.

```php
use PHPUnit\Xpath\Assert as XpathAssertions;
use PHPUnit\Xpath\Constraint as XpathConstraints;

class MyProjectExampleTest extends \PHPUnit\Framework\TestCase
{
    use XpathAssertions;
    use XpathConstraints;
}
```

## Usage

### Constraints

Use trait `PHPUnit\Xpath\Constraint`. They can be used with `assertThat()` or 
with Mocks.

#### self::matchesXpathExpression()

```php
function matchesXpathExpression(string $expression, array|\ArrayAccess $namespaces = [])
```

Validate if the provided Xpath expression matches something that is TRUE and not empty.
It will fail if the expression returns an empty node list or an empty string or FALSE.

```php
public function testChildElementExistsInDocument()
{
    $document = new \DOMDocument();
    $document->loadXML('<root><child>TEXT</child></root>');

    self::assertThat(
        $document,
        self::matchesXpathExpression('//child')
    );
}
```

#### self::matchesXpathResultCount()

```php
function matchesXpathResultCount(
    int $expectedCount, string $expression, array|\ArrayAccess $namespaces = []
)
```

Returns true if the provided Xpath expression matches exactly the expected count of nodes.

```php
public function testChildElementExistsOnTimeInDocument()
{
    $document = new \DOMDocument();
    $document->loadXML('<root><child>TEXT</child></root>');

    self::assertThat(
        $document,
        self::matchesXpathResultCount(1, '//child')
    );
}
```

#### self::equalToXpathResult()

```php
function equalToXpathResult(
    string|\DOMNode|\DOMNode[] $expectedNodes, 
    string $expression, array|\ArrayAccess, 
    $namespaces = []
)
```

Compares the serialized XML of the matched nodes with and provided XML string or DOM.

```php
public function testCompareChildElementFromDocument()
{
    $document = new \DOMDocument();
    $document->loadXML('<root><child>TEXT</child></root>');

    self::assertThat(
        $document,
        self::equalToXpathResult(
            '<child>TEXT</child>',
            '//child'
        )
    );
}
```

### Assertions

Use trait `PHPUnit\Xpath\Assert`. These assertions are shortcuts for 
`assertThat()`.

* self::assertXpathMatch()
* self::assertXpathCount()
* self::assertXpathEquals()

### Namespaces 

All methods have an optional argument that allow to provide an namespace definition.

```php
public function testChildWithNamespaceElementExistsTwoTimesInDocument()
{
    $document = new \DOMDocument();
    $document->loadXML(
        '<example:root xmlns:example="urn:example">
        <example:child>TEXT</example:child>
        <example:child>TEXT</example:child>
        </example:root>'
    );

    self::assertThat(
        $document,
        self::matchesXpathResultCount(2, '//e:child', ['e' => 'urn:example'])
    );
}
```
