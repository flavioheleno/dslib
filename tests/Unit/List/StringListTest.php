<?php
declare(strict_types = 1);

namespace DsLib\Test\Unit\List;

use DsLib\Contract\StringFilterInterface;
use DsLib\Contract\StringMapInterface;
use DsLib\List\StringList;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StringList::class)]
final class StringListTest extends TestCase {
  public function testFromInvalidArray(): void {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('$array must only contain string values');

    StringList::fromArray(['a', 1]);
  }

  public function testFromArray(): void {
    $arr = ['a', 'b'];
    $list = StringList::fromArray($arr);

    $this->assertEquals($arr, $list->toArray());
  }

  public function testEmptyList(): void {
    $list = new StringList();

    $this->assertTrue($list->isEmpty());
    $list->push('a');
    $this->assertFalse($list->isEmpty());
  }

  public function testAll(): void {
    $list = new StringList('b', 'c', 'd');

    $this->assertTrue($list->all(
      new class implements StringFilterInterface {
        public function __invoke(string $value, int $index): bool {
          return strlen($value) === 1;
        }
      }
    ));
    $this->assertFalse($list->all(
      new class implements StringFilterInterface {
        public function __invoke(string $value, int $index): bool {
          return strlen($value) > 1;
        }
      }
    ));
  }

  public function testAny(): void {
    $list = new StringList('b', 'd');

    $this->assertTrue($list->any(
      new class implements StringFilterInterface {
        public function __invoke(string $value, int $index): bool {
          return $value === 'd';
        }
      }
    ));
    $this->assertFalse($list->any(
      new class implements StringFilterInterface {
        public function __invoke(string $value, int $index): bool {
          return strlen($value) > 1;
        }
      }
    ));
  }

  public function testClear(): void {
    $list = new StringList('b', 'c', 'd', 'e');

    $this->assertFalse($list->isEmpty());
    $list->clear();
    $this->assertTrue($list->isEmpty());
  }

  public function testDiff(): void {
    $list = new StringList('b', 'c', 'd', 'e');

    $diff = $list->diff(new StringList('c', 'd'));
    $this->assertEquals(['b', 'e'], $diff->toArray());

    $diff = $list->diff(new StringList('c'), new StringList('d'));
    $this->assertEquals(['b', 'e'], $diff->toArray());

    $diff = $list->diff(new StringList('b', 'c', 'd', 'e'));
    $this->assertEmpty($diff->toArray());

    $diff = $list->diff(new StringList('b', 'c'), new StringList('d', 'e'));
    $this->assertEmpty($diff->toArray());
  }

  public function testFilter(): void {
    $list = new StringList('b', 'c', 'd', 'e');

    $filtered = $list->filter(
      new class implements StringFilterInterface {
        public function __invoke(string $value, int $index): bool {
          return $value === 'c' || $value === 'e';
        }
      }
    );
    $this->assertEquals(['c', 'e'], $filtered->toArray());
  }

  public function testHas(): void {
    $list = new StringList();

    $this->assertFalse($list->has('a'));
    $list->push('a');
    $this->assertTrue($list->has('a'));
  }

  public function testIntersect(): void {
    $list = new StringList('a', 'b', 'c');

    $intersect = $list->intersect(new StringList('b', 'c', 'd'));
    $this->assertEquals(['b', 'c'], $intersect->toArray());

    $intersect = $list->intersect(new StringList('d', 'e'));
    $this->assertEmpty($intersect->toArray());
  }

  public function testJoin(): void {
    $list = new StringList('a', 'b', 'c');

    $this->assertSame('a,b,c', $list->join(','));
  }

  public function testMap(): void {
    $list = new StringList('a', 'b', 'c');

    $map = $list->map(
      new class implements StringMapInterface {
        public function __invoke(string $value): string {
          return $value . '?';
        }
      }
    );

    $this->assertEquals(['a?', 'b?', 'c?'], $map->toArray());
  }

  public function testMerge(): void {
    $list = new StringList('a', 'b');
    $list->merge(new StringList('c', 'd'));

    $this->assertEquals(['a', 'b', 'c', 'd'], $list->toArray());
  }

  public function testPop(): void {
    $list = new StringList('a', 'b', 'c', 'd');

    $this->assertSame('d', $list->pop());
    $this->assertSame('c', $list->pop());
    $this->assertSame('b', $list->pop());
    $this->assertSame('a', $list->pop());
  }

  public function testPush(): void {
    $list = new StringList();

    $list
      ->push('a')
      ->push('b')
      ->push('c');

    $this->assertEquals(['a', 'b', 'c'], $list->toArray());
  }

  public function testRsort(): void {
    $list = new StringList('c', 'e', 'b', 'a');

    $list->rsort();
    $this->assertEquals(['e', 'c', 'b', 'a'], $list->toArray());
  }

  public function testShift(): void {
    $list = new StringList('a', 'b', 'c', 'd');

    $this->assertSame('a', $list->shift());
    $this->assertSame('b', $list->shift());
    $this->assertSame('c', $list->shift());
    $this->assertSame('d', $list->shift());
  }

  public function testSlice(): void {
    $list = new StringList('a', 'b', 'c', 'd');

    $slice = $list->slice(2, 1);
    $this->assertEquals(['c'], $slice->toArray());

    $slice = $list->slice(2, 2);
    $this->assertEquals(['c', 'd'], $slice->toArray());

    $slice = $list->slice(3);
    $this->assertEquals(['d'], $slice->toArray());
  }

  public function testSort(): void {
    $list = new StringList('c', 'e', 'b', 'a');

    $list->sort();
    $this->assertEquals(['a', 'b', 'c', 'e'], $list->toArray());
  }

  public function testUnique(): void {
    $list = new StringList('c', 'c', 'd');

    $unique = $list->unique();
    $this->assertEquals(['c', 'd'], $unique->toArray());
  }

  public function testUnshift(): void {
    $list = new StringList();

    $list
      ->unshift('a')
      ->unshift('b')
      ->unshift('c');

    $this->assertEquals(['c', 'b', 'a'], $list->toArray());
  }

  public function testToArray(): void {
    $list = new StringList('a', 'b', 'c', 'd');

    $this->assertEquals(['a', 'b', 'c', 'd'], $list->toArray());
    $list->push('b');
    $this->assertEquals(['a', 'b', 'c', 'd', 'b'], $list->toArray());
  }

  public function testCountable(): void {
    $list = new StringList();

    $this->assertCount(0, $list);
    $list->push('b');
    $this->assertCount(1, $list);
  }

  public function testIterator(): void {
    $list = new StringList('b', 'c');

    $this->assertTrue($list->valid());
    $this->assertSame(0, $list->key());
    $this->assertSame('b', $list->current());

    $list->next();
    $this->assertTrue($list->valid());
    $this->assertSame(1, $list->key());
    $this->assertSame('c', $list->current());

    $list->next();
    $this->assertFalse($list->valid());
    $list->rewind();
    $this->assertTrue($list->valid());
  }
}
