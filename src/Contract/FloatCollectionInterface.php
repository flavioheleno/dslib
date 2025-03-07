<?php
declare(strict_types = 1);

namespace DsLib\Contract;

use Countable;
use Iterator;

interface FloatCollectionInterface extends Countable, Iterator {
  /**
   * @param list<float> $array
   */
  public static function fromArray(array $array): static;
  public function isEmpty(): bool;
  public function all(FloatFilterInterface $filter): bool;
  public function any(FloatFilterInterface $filter): bool;
  public function clear(): void;
  public function diff(FloatCollectionInterface ...$collections): static;
  public function filter(FloatFilterInterface $filter): static;
  public function has(float $value): bool;
  public function intersect(FloatCollectionInterface ...$collections): static;
  public function map(FloatMapInterface $map): static;
  public function merge(FloatCollectionInterface ...$collections): self;
  public function pop(): float;
  public function push(float $value): self;
  public function rsort(): void;
  public function shift(): float;
  public function slice(int $offset, int|null $length = null): static;
  public function sort(): void;
  public function sum(): float;
  public function unique(): static;
  public function unshift(float $value): self;
  /**
   * @return list<int>
   */
  public function toArray(): array;
}
