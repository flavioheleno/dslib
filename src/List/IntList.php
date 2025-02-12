<?php
declare(strict_types = 1);

namespace DsLib\List;

use DsLib\Contract\IntCollectionInterface;

class IntList implements IntCollectionInterface {
  /**
   * @var list<int>
   */
  protected array $data;

  public function __construct(int ...$ints) {
    $this->data = $ints;
  }

  public function isEmpty(): bool {
    return $this->data === [];
  }

  /** Array Methods **/

  /**
   * @param callable(int,int):bool $callback
   */
  public function all(callable $callback): bool {
    return array_all($this->data, $callback);
  }

  /**
   * @param callable(int,int):bool $callback
   */
  public function any(callable $callback): bool {
    return array_any($this->data, $callback);
  }

  public function clear(): void {
    $this->data = [];
  }

  public function diff(IntCollectionInterface $collection): static {
    return new static(...array_diff($this->data, $collection->toArray()));
  }

  /**
   * @param callable(int):bool $callback
   */
  public function filter(callable $callback): static {
    return new static(...array_filter($this->data, $callback));
  }

  public function has(int $value): bool {
    return in_array($value, $this->data, true);
  }

  public function intersect(IntCollectionInterface $collection): static {
    return new static(...array_intersect($this->data, $collection->toArray()));
  }

  /**
   * @param callable(int):bool $callback
   */
  public function map(callable $callback): static {
    return new static(...array_map($callback, $this->data));
  }

  public function merge(IntCollectionInterface $collection): self {
    $this->data = array_merge($this->data, $collection->toArray());

    return $this;
  }

  public function pop(): int {
    return (int)array_pop($this->data);
  }

  public function push(int $value): self {
    array_push($this->data, $value);

    return $this;
  }

  public function rsort(): void {
    rsort($this->data, SORT_NUMERIC);
  }

  public function shift(): int {
    return (int)array_shift($this->data);
  }

  public function slice(int $offset, int|null $length = null): static {
    return new static(...array_slice($this->data, $offset, $length));
  }

  public function sort(): void {
    sort($this->data, SORT_NUMERIC);
  }

  public function sum(): int {
    return array_sum($this->data);
  }

  public function unique(): static {
    return new static(...array_unique($this->data, SORT_NUMERIC));
  }

  public function unshift(int $value): self {
    array_unshift($this->data, $value);

    return $this;
  }

  /**
   * @return list<int>
   */
  public function toArray(): array {
    return $this->data;
  }

  /** Countable **/
  public function count(): int {
    return count($this->data);
  }

  /** Iterator **/
  public function current(): int {
    return current($this->data);
  }

  public function key(): int {
    return key($this->data);
  }

  public function next(): void {
    next($this->data);
  }

  public function rewind(): void {
    reset($this->data);
  }

  public function valid(): bool {
    return current($this->data) !== false;
  }
}
