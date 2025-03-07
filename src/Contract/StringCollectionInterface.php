<?php
declare(strict_types = 1);

namespace DsLib\Contract;

use Countable;
use Iterator;

interface StringCollectionInterface extends Countable, Iterator {
  /**
   * @param list<string> $array
   */
  public static function fromArray(array $array): static;
  public function isEmpty(): bool;
  public function all(StringFilterInterface $filter): bool;
  public function any(StringFilterInterface $filter): bool;
  public function clear(): void;
  public function diff(StringCollectionInterface ...$collections): static;
  public function filter(StringFilterInterface $filter): static;
  public function has(string $value): bool;
  public function intersect(StringCollectionInterface ...$collections): static;
  public function join(string $separator): string;
  public function map(StringMapInterface $map): static;
  public function merge(StringCollectionInterface ...$collections): self;
  public function pop(): string;
  public function push(string $value): self;
  public function rsort(): void;
  public function shift(): string;
  public function slice(int $offset, int|null $length = null): static;
  public function sort(): void;
  public function unique(): static;
  public function unshift(string $value): self;
  /**
   * @return list<string>
   */
  public function toArray(): array;
}
