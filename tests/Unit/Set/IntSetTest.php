<?php
declare(strict_types = 1);

namespace DsLib\Test\Unit\Set;

use DsLib\List\IntList;
use DsLib\Set\IntSet;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(IntSet::class)]
#[UsesClass(IntList::class)]
final class IntSetTest extends TestCase {
  public function testMerge(): void {
    $set = new IntSet(0, 1);
    $set->merge(new IntSet(1, 2, 3));

    $this->assertEquals([0, 1, 2, 3], $set->toArray());
  }

  public function testPush(): void {
    $set = new IntSet();

    $set
      ->push(0)
      ->push(1)
      ->push(1)
      ->push(2);

    $this->assertEquals([0, 1, 2], $set->toArray());
  }

  public function testUnshift(): void {
    $set = new IntSet();

    $set
      ->unshift(0)
      ->unshift(0)
      ->unshift(1)
      ->unshift(2);

    $this->assertEquals([2, 1, 0], $set->toArray());
  }
}
