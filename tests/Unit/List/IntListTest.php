<?php
declare(strict_types = 1);

namespace DsLib\Test\Unit\List;

use DsLib\Contract\IntFilterInterface;
use DsLib\Contract\IntMapInterface;
use DsLib\List\IntList;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(IntList::class)]
final class IntListTest extends TestCase {
  public function testFromInvalidArray(): void {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('$array must only contain integer values');

    IntList::fromArray([1, 'b']);
  }

  public function testFromArray(): void {
    $arr = [1, 2];
    $list = IntList::fromArray($arr);

    $this->assertEquals($arr, $list->toArray());
  }

  public function testEmptyList(): void {
    $list = new IntList();

    $this->assertTrue($list->isEmpty());
    $list->push(0);
    $this->assertFalse($list->isEmpty());
  }

  public function testAll(): void {
    $list = new IntList(1, 2, 3);

    $this->assertTrue($list->all(
      new class implements IntFilterInterface {
        public function __invoke(int $value, int $index): bool {
          return $value > 0;
        }
      }
    ));
    $this->assertFalse($list->all(
      new class implements IntFilterInterface {
        public function __invoke(int $value, int $index): bool {
          return $value % 2 === 0;
        }
      }
    ));
  }

  public function testAny(): void {
    $list = new IntList(1, 3);

    $this->assertTrue($list->any(
      new class implements IntFilterInterface {
        public function __invoke(int $value, int $index): bool {
          return $value % 3 === 0;
        }
      }
    ));
    $this->assertFalse($list->any(
      new class implements IntFilterInterface {
        public function __invoke(int $value, int $index): bool {
          return $value % 2 === 0;
        }
      }
    ));
  }

  public function testClear(): void {
    $list = new IntList(1, 2, 3, 4);

    $this->assertFalse($list->isEmpty());
    $list->clear();
    $this->assertTrue($list->isEmpty());
  }

  public function testDiff(): void {
    $list = new IntList(1, 2, 3, 4);

    $diff = $list->diff(new IntList(2, 3));
    $this->assertEquals([1, 4], $diff->toArray());

    $diff = $list->diff(new IntList(2), new IntList(3));
    $this->assertEquals([1, 4], $diff->toArray());

    $diff = $list->diff(new IntList(1, 2, 3, 4));
    $this->assertEmpty($diff->toArray());

    $diff = $list->diff(new IntList(1, 2), new IntList(3, 4));
    $this->assertEmpty($diff->toArray());
  }

  public function testFilter(): void {
    $list = new IntList(1, 2, 3, 4);

    $filtered = $list->filter(
      new class implements IntFilterInterface {
        public function __invoke(int $value, int $index): bool {
          return $value % 2 === 0;
        }
      }
    );
    $this->assertEquals([2, 4], $filtered->toArray());
  }

  public function testHas(): void {
    $list = new IntList();

    $this->assertFalse($list->has(0));
    $list->push(0);
    $this->assertTrue($list->has(0));
  }

  public function testIntersect(): void {
    $list = new IntList(0, 1, 2);

    $intersect = $list->intersect(new IntList(1, 2, 3));
    $this->assertEquals([1, 2], $intersect->toArray());

    $intersect = $list->intersect(new IntList(3, 4));
    $this->assertEmpty($intersect->toArray());
  }

  public function testMap(): void {
    $list = new IntList(0, 1, 2);

    $map = $list->map(
      new class implements IntMapInterface {
        public function __invoke(int $value): int {
          return $value * 2;
        }
      }
    );

    $this->assertEquals([0, 2, 4], $map->toArray());
  }

  public function testMerge(): void {
    $list = new IntList(0, 1);
    $list->merge(new IntList(2, 3));

    $this->assertEquals([0, 1, 2, 3], $list->toArray());
  }

  public function testPop(): void {
    $list = new IntList(0, 1, 2, 3);

    $this->assertSame(3, $list->pop());
    $this->assertSame(2, $list->pop());
    $this->assertSame(1, $list->pop());
    $this->assertSame(0, $list->pop());
  }

  public function testPush(): void {
    $list = new IntList();

    $list
      ->push(0)
      ->push(1)
      ->push(2);

    $this->assertEquals([0, 1, 2], $list->toArray());
  }

  public function testRsort(): void {
    $list = new IntList(2, 4, 1, 0);

    $list->rsort();
    $this->assertEquals([4, 2, 1, 0], $list->toArray());
  }

  public function testShift(): void {
    $list = new IntList(0, 1, 2, 3);

    $this->assertSame(0, $list->shift());
    $this->assertSame(1, $list->shift());
    $this->assertSame(2, $list->shift());
    $this->assertSame(3, $list->shift());
  }

  public function testSlice(): void {
    $list = new IntList(0, 1, 2, 3);

    $slice = $list->slice(2, 1);
    $this->assertEquals([2], $slice->toArray());

    $slice = $list->slice(2, 2);
    $this->assertEquals([2, 3], $slice->toArray());

    $slice = $list->slice(3);
    $this->assertEquals([3], $slice->toArray());
  }

  public function testSort(): void {
    $list = new IntList(2, 4, 1, 0);

    $list->sort();
    $this->assertEquals([0, 1, 2, 4], $list->toArray());
  }

  public function testSum(): void {
    $list = new IntList(1, 2, 3);

    $this->assertSame(6, $list->sum());
  }

  public function testUnique(): void {
    $list = new IntList(2, 2, 3);

    $unique = $list->unique();
    $this->assertEquals([2, 3], $unique->toArray());
  }

  public function testUnshift(): void {
    $list = new IntList();

    $list
      ->unshift(0)
      ->unshift(1)
      ->unshift(2);

    $this->assertEquals([2, 1, 0], $list->toArray());
  }

  public function testToArray(): void {
    $list = new IntList(0, 1, 2, 3);

    $this->assertEquals([0, 1, 2, 3], $list->toArray());
    $list->push(1);
    $this->assertEquals([0, 1, 2, 3, 1], $list->toArray());
  }

  public function testCountable(): void {
    $list = new IntList();

    $this->assertCount(0, $list);
    $list->push(1);
    $this->assertCount(1, $list);
  }

  public function testIterator(): void {
    $list = new IntList(1, 2);

    $this->assertTrue($list->valid());
    $this->assertSame(0, $list->key());
    $this->assertSame(1, $list->current());

    $list->next();
    $this->assertTrue($list->valid());
    $this->assertSame(1, $list->key());
    $this->assertSame(2, $list->current());

    $list->next();
    $this->assertFalse($list->valid());
    $list->rewind();
    $this->assertTrue($list->valid());
  }
}
