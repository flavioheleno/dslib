<?php
declare(strict_types = 1);

namespace DsLib\Test\Unit\Set;

use DsLib\List\StringList;
use DsLib\Set\StringSet;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(StringSet::class)]
#[UsesClass(StringList::class)]
final class StringSetTest extends TestCase {
  public function testMerge(): void {
    $set = new StringSet('a', 'b');
    $set->merge(new StringSet('b', 'c', 'd'));

    $this->assertEquals(['a', 'b', 'c', 'd'], $set->toArray());
  }

  public function testPush(): void {
    $set = new StringSet();

    $set
      ->push('a')
      ->push('b')
      ->push('b')
      ->push('c');

    $this->assertEquals(['a', 'b', 'c'], $set->toArray());
  }

  public function testUnshift(): void {
    $set = new StringSet();

    $set
      ->unshift('a')
      ->unshift('a')
      ->unshift('b')
      ->unshift('c');

    $this->assertEquals(['c', 'b', 'a'], $set->toArray());
  }
}
