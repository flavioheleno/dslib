<?php
declare(strict_types = 1);

namespace DsLib\List;

use DsLib\Contract\FloatCollectionInterface;

class FloatList implements FloatCollectionInterface {
  /**
   * @var list<float>
   */
  protected array $data;

  public function __construct(float ...$floats) {
    $this->data = $floats;
  }

  public function isEmpty(): bool {
    return $this->data === [];
  }

  /** Array Methods **/

  /**
   * @param callable(float,float):bool $callback
   */
  public function all(callable $callback): bool {
    return array_all($this->data, $callback);
  }

  /**
   * @param callable(float,float):bool $callback
   */
  public function any(callable $callback): bool {
    return array_any($this->data, $callback);
  }

  public function clear(): void {
    $this->data = [];
  }

  public function diff(FloatCollectionInterface $collection): static {
    return new static(...array_diff($this->data, $collection->toArray()));
  }

  /**
   * @param callable(float):bool $callback
   */
  public function filter(callable $callback): static {
    return new static(...array_filter($this->data, $callback));
  }

  public function has(float $value): bool {
    return in_array($value, $this->data, true);
  }

  public function intersect(FloatCollectionInterface $collection): static {
    return new static(...array_intersect($this->data, $collection->toArray()));
  }

  /**
   * @param callable(float):bool $callback
   */
  public function map(callable $callback): static {
    return new static(...array_map($callback, $this->data));
  }

  public function merge(FloatCollectionInterface $collection): self {
    $this->data = array_merge($this->data, $collection->toArray());

    return $this;
  }

  public function pop(): float {
    return (float)array_pop($this->data);
  }

  public function push(float $value): self {
    array_push($this->data, $value);

    return $this;
  }

  public function rsort(): void {
    rsort($this->data, SORT_NUMERIC);
  }

  public function shift(): float {
    return (float)array_shift($this->data);
  }

  public function slice(int $offset, int|null $length = null): static {
    return new static(...array_slice($this->data, $offset, $length));
  }

  public function sort(): void {
    sort($this->data, SORT_NUMERIC);
  }

  public function sum(): float {
    return array_sum($this->data);
  }

  public function unique(): static {
    return new static(...array_unique($this->data, SORT_NUMERIC));
  }

  public function unshift(float $value): self {
    array_unshift($this->data, $value);

    return $this;
  }

  /**
   * @return list<float>
   */
  public function toArray(): array {
    return $this->data;
  }

  /** Countable **/
  public function count(): int {
    return count($this->data);
  }

  /** Iterator **/
  public function current(): float {
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
