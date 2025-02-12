<?php
declare(strict_types = 1);

namespace DsLib\Contract;

use Countable;
use Iterator;

interface StringCollectionInterface extends Countable, Iterator {
  public function isEmpty(): bool;
  /**
   * @param callable(string,int):bool $callback
   */
  public function all(callable $callback): bool;
  /**
   * @param callable(string,int):bool $callback
   */
  public function any(callable $callback): bool;
  public function clear(): void;
  public function diff(StringCollectionInterface ...$collections): static;
  /**
   * @param callable(string):bool $callback
   */
  public function filter(callable $callback): static;
  public function has(string $value): bool;
  public function intersect(StringCollectionInterface ...$collections): static;
  public function join(string $separator): string;
  /**
   * @param callable(int):bool $callback
   */
  public function map(callable $callback): static;
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
