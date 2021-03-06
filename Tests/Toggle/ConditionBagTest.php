<?php

namespace DZunke\FeatureFlagsBundle\Tests\Toggle;

use DZunke\FeatureFlagsBundle\Toggle\ConditionBag;
use DZunke\FeatureFlagsBundle\Toggle\Conditions\ConditionInterface;
use PHPUnit_Framework_TestCase;
use IteratorAggregate;
use Countable;
use ArrayIterator;

class ConditionBagTest extends PHPUnit_Framework_TestCase
{

    public function testItImplementsClasses()
    {
        $sut = new ConditionBag();
        $this->assertInstanceOf(IteratorAggregate::class, $sut);
        $this->assertInstanceOf(Countable::class, $sut);
    }

    public function testConditionBag()
    {
        $conditionMock = $this->getMock(ConditionInterface::class);
        $conditionMock->method('__toString')->willReturn('test_condition');

        $sut = new ConditionBag();
        $sut->add([$conditionMock]);

        $this->assertInstanceOf(ArrayIterator::class, $sut->getIterator());
        $this->assertCount(1, $sut);
        $this->assertInternalType('array', $sut->all());
        $this->assertNull($sut->get('test'));
        $this->assertInstanceOf(ConditionInterface::class, $sut->get('test_condition'));
        $this->assertInternalType('array', $sut->keys());
        $this->assertCount(1, $sut->keys());
        $this->assertFalse($sut->has('test'));
        $this->assertTrue($sut->has('test_condition'));
        $this->assertCount(0, $sut->remove('test_condition'));
    }

}