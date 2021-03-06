<?php

namespace PHPUnit\Xpath;

require_once __DIR__.'/TestCase.php';

class ConstraintTest extends TestCase
{
    use Constraint;

    public function testAssertXpathMatchSuccess() {
        self::assertThat(
            $this->getXMLDocument(),
            self::matchesXpathExpression('//child')
        );
    }

    public function testAssertXpathCountSuccess() {
        self::assertThat(
            $this->getXMLDocument(),
            self::matchesXpathResultCount(1,'//child')
        );
    }

    public function testAssertXpathEqualsSuccess() {
        $expected = $this->getXMLDocument()->documentElement->firstChild;
        self::assertThat(
            $this->getXMLDocument(),
            self::equalToXpathResult($expected,'//child')
        );
    }

    public function testAssertXpathEqualsWithNamespaceSuccess() {
        $expected = $this->getXMLDocument()->documentElement->childNodes;
        self::assertThat(
            $this->getXMLDocument(),
            self::equalToXpathResult($expected, '//child|//x:child', ['x' => 'urn:dummy'])
        );
    }
}
