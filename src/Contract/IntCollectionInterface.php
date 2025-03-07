<?php
declare(strict_types = 1);

namespace DsLib\Contract;

use Countable;
use Iterator;

interface IntCollectionInterface extends Countable, Iterator {
  /**
   * @param list<int> $array
   */
  public static function fromArray(array $array): static;
  public function isEmpty(): bool;
  public function all(IntFilterInterface $filter): bool;
  public function any(IntFilterInterface $filter): bool;
  public function clear(): void;
  public function diff(IntCollectionInterface ...$collections): static;
  public function filter(IntFilterInterface $filter): static;
  public function has(int $value): bool;
  public function intersect(IntCollectionInterface ...$collections): static;
  public function map(IntMapInterface $map): static;
  public function merge(IntCollectionInterface ...$collections): self;
  public function pop(): int;
  public function push(int $value): self;
  public function rsort(): void;
  public function shift(): int;
  public function slice(int $offset, int|null $length = null): static;
  public function sort(): void;
  public function sum(): int;
  public function unique(): static;
  public function unshift(int $value): self;
  /**
   * @return list<int>
   */
  public function toArray(): array;
}
