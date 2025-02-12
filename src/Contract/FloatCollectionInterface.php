<?php
declare(strict_types = 1);

namespace DsLib\Contract;

use Countable;
use Iterator;

interface FloatCollectionInterface extends Countable, Iterator {
  public function isEmpty(): bool;
  /**
   * @param callable(float,float):bool $callback
   */
  public function all(callable $callback): bool;
  /**
   * @param callable(float,float):bool $callback
   */
  public function any(callable $callback): bool;
  public function clear(): void;
  public function diff(FloatCollectionInterface ...$collections): static;
  /**
   * @param callable(float):bool $callback
   */
  public function filter(callable $callback): static;
  public function has(float $value): bool;
  public function intersect(FloatCollectionInterface ...$collections): static;
  /**
   * @param callable(float):bool $callback
   */
  public function map(callable $callback): static;
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
