<?php
declare(strict_types = 1);

namespace DsLib\Test\Unit\List;

use DsLib\List\FloatList;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FloatList::class)]
final class FloatListTest extends TestCase {
  public function testFromInvalidArray(): void {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('$array must only contain float values');

    FloatList::fromArray([0.1, 'a']);
  }

  public function testFromArray(): void {
    $arr = [0.1, 0.2];
    $list = FloatList::fromArray($arr);

    $this->assertEquals($arr, $list->toArray());
  }

  public function testEmptyList(): void {
    $list = new FloatList();

    $this->assertTrue($list->isEmpty());
    $list->push(0.1);
    $this->assertFalse($list->isEmpty());
  }

  public function testAll(): void {
    $list = new FloatList(0.1, 0.2, 0.3);

    $this->assertTrue($list->all(static function (float $value): bool {
      return $value > 0;
    }));
    $this->assertFalse($list->all(static function (float $value): bool {
      return $value < 0.2;
    }));
  }

  public function testAny(): void {
    $list = new FloatList(0.1, 0.3);

    $this->assertTrue($list->any(static function (float $value): bool {
      return $value > 0.2;
    }));
    $this->assertFalse($list->any(static function (float $value): bool {
      return $value < 0.1;
    }));
  }

  public function testClear(): void {
    $list = new FloatList(0.1, 0.2, 0.3, 0.4);

    $this->assertFalse($list->isEmpty());
    $list->clear();
    $this->assertTrue($list->isEmpty());
  }

  public function testDiff(): void {
    $list = new FloatList(0.1, 0.2, 0.3, 0.4);

    $diff = $list->diff(new FloatList(0.2, 0.3));
    $this->assertEquals([0.1, 0.4], $diff->toArray());

    $diff = $list->diff(new FloatList(0.2), new FloatList(0.3));
    $this->assertEquals([0.1, 0.4], $diff->toArray());

    $diff = $list->diff(new FloatList(0.1, 0.2, 0.3, 0.4));
    $this->assertEmpty($diff->toArray());

    $diff = $list->diff(new FloatList(0.1, 0.2), new FloatList(0.3, 0.4));
    $this->assertEmpty($diff->toArray());
  }

  public function testFilter(): void {
    $list = new FloatList(-0.1, -0.2, 0.3, 0.4);

    $filtered = $list->filter(static function (float $value): bool {
      return $value > 0;
    });
    $this->assertEquals([0.3, 0.4], $filtered->toArray());
  }

  public function testHas(): void {
    $list = new FloatList();

    $this->assertFalse($list->has(0.1));
    $list->push(0.1);
    $this->assertTrue($list->has(0.1));
  }

  public function testIntersect(): void {
    $list = new FloatList(0.1, 0.2, 0.3);

    $intersect = $list->intersect(new FloatList(0.2, 0.3, 0.4));
    $this->assertEquals([0.2, 0.3], $intersect->toArray());

    $intersect = $list->intersect(new FloatList(0.4, 0.5));
    $this->assertEmpty($intersect->toArray());
  }

  public function testMap(): void {
    $list = new FloatList(0.0, 0.1, 0.2);

    $map = $list->map(static function (float $value): float {
      return $value * 2;
    });

    $this->assertEquals([0.0, 0.2, 0.4], $map->toArray());
  }

  public function testMerge(): void {
    $list = new FloatList(0.1, 0.2);
    $list->merge(new FloatList(0.3, 0.4));

    $this->assertEquals([0.1, 0.2, 0.3, 0.4], $list->toArray());
  }

  public function testPop(): void {
    $list = new FloatList(0.1, 0.2, 0.3, 0.4);

    $this->assertSame(0.4, $list->pop());
    $this->assertSame(0.3, $list->pop());
    $this->assertSame(0.2, $list->pop());
    $this->assertSame(0.1, $list->pop());
  }

  public function testPush(): void {
    $list = new FloatList();

    $list
      ->push(0.1)
      ->push(0.2)
      ->push(0.3);

    $this->assertEquals([0.1, 0.2, 0.3], $list->toArray());
  }

  public function testRsort(): void {
    $list = new FloatList(0.2, 0.4, 0.1, 0.5);

    $list->rsort();
    $this->assertEquals([0.5, 0.4, 0.2, 0.1], $list->toArray());
  }

  public function testShift(): void {
    $list = new FloatList(0.1, 0.2, 0.3, 0.4);

    $this->assertSame(0.1, $list->shift());
    $this->assertSame(0.2, $list->shift());
    $this->assertSame(0.3, $list->shift());
    $this->assertSame(0.4, $list->shift());
  }

  public function testSlice(): void {
    $list = new FloatList(0.1, 0.2, 0.3, 0.4);

    $slice = $list->slice(2, 1);
    $this->assertEquals([0.3], $slice->toArray());

    $slice = $list->slice(2, 2);
    $this->assertEquals([0.3, 0.4], $slice->toArray());

    $slice = $list->slice(3);
    $this->assertEquals([0.4], $slice->toArray());
  }

  public function testSort(): void {
    $list = new FloatList(0.2, 0.4, 0.1, 0.5);

    $list->sort();
    $this->assertEquals([0.1, 0.2, 0.4, 0.5], $list->toArray());
  }

  public function testSum(): void {
    $list = new FloatList(0.1, 0.2, 0.3);

    $this->assertEqualsWithDelta(0.6, $list->sum(), 0.0001);
  }

  public function testUnique(): void {
    $list = new FloatList(0.2, 0.2, 0.3);

    $unique = $list->unique();
    $this->assertEquals([0.2, 0.3], $unique->toArray());
  }

  public function testUnshift(): void {
    $list = new FloatList();

    $list
      ->unshift(0.1)
      ->unshift(0.2)
      ->unshift(0.3);

    $this->assertEquals([0.3, 0.2, 0.1], $list->toArray());
  }

  public function testToArray(): void {
    $list = new FloatList(0.1, 0.2, 0.3, 0.4);

    $this->assertEquals([0.1, 0.2, 0.3, 0.4], $list->toArray());
    $list->push(0.1);
    $this->assertEquals([0.1, 0.2, 0.3, 0.4, 0.1], $list->toArray());
  }

  public function testCountable(): void {
    $list = new FloatList();

    $this->assertCount(0, $list);
    $list->push(0.1);
    $this->assertCount(1, $list);
  }

  public function testIterator(): void {
    $list = new FloatList(0.1, 0.2);

    $this->assertTrue($list->valid());
    $this->assertSame(0, $list->key());
    $this->assertSame(0.1, $list->current());

    $list->next();
    $this->assertTrue($list->valid());
    $this->assertSame(1, $list->key());
    $this->assertSame(0.2, $list->current());

    $list->next();
    $this->assertFalse($list->valid());
    $list->rewind();
    $this->assertTrue($list->valid());
  }
}
