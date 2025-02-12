<?php
declare(strict_types = 1);

namespace DsLib\Contract;

use Countable;
use Iterator;

interface IntCollectionInterface extends Countable, Iterator {
  public function isEmpty(): bool;
  /**
   * @param callable(int,int):bool $callback
   */
  public function all(callable $callback): bool;
  /**
   * @param callable(int,int):bool $callback
   */
  public function any(callable $callback): bool;
  public function clear(): void;
  public function diff(IntCollectionInterface $collection): static;
  /**
   * @param callable(int):bool $callback
   */
  public function filter(callable $callback): static;
  public function has(int $value): bool;
  public function intersect(IntCollectionInterface $collection): static;
  /**
   * @param callable(int):bool $callback
   */
  public function map(callable $callback): static;
  public function merge(IntCollectionInterface $collection): self;
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
