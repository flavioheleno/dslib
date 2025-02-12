<?php
declare(strict_types = 1);

namespace DsLib\Test\Unit\Set;

use DsLib\List\FloatList;
use DsLib\Set\FloatSet;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FloatSet::class)]
#[UsesClass(FloatList::class)]
final class FloatSetTest extends TestCase {
  public function testMerge(): void {
    $set = new FloatSet(0.1, 0.2);
    $set->merge(new FloatSet(0.1, 0.2, 0.3));

    $this->assertEquals([0.1, 0.2, 0.3], $set->toArray());
  }

  public function testPush(): void {
    $set = new FloatSet();

    $set
      ->push(0.1)
      ->push(0.2)
      ->push(0.2)
      ->push(0.3);

    $this->assertEquals([0.1, 0.2, 0.3], $set->toArray());
  }

  public function testUnshift(): void {
    $set = new FloatSet();

    $set
      ->unshift(0.1)
      ->unshift(0.1)
      ->unshift(0.2)
      ->unshift(0.3);

    $this->assertEquals([0.3, 0.2, 0.1], $set->toArray());
  }
}
