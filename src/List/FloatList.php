<?php
declare(strict_types = 1);

namespace DsLib\List;

use DsLib\Contract\FloatCollectionInterface;
use DsLib\Contract\FloatFilterInterface;
use DsLib\Contract\FloatMapInterface;
use InvalidArgumentException;

class FloatList implements FloatCollectionInterface {
  /**
   * @var list<float>
   */
  protected array $data;

  /**
   * @param list<float> $array
   */
  public static function fromArray(array $array): static {
    $invalid = array_filter(
      $array,
      static function (mixed $value): bool {
        return is_float($value) === false;
      }
    );
    if ($invalid !== []) {
      throw new InvalidArgumentException('$array must only contain float values');
    }

    return new static(...$array);
  }

  public function __construct(float ...$floats) {
    $this->data = $floats;
  }

  public function isEmpty(): bool {
    return $this->data === [];
  }

  /** Array Methods **/
  public function all(FloatFilterInterface $filter): bool {
    return array_all($this->data, $filter);
  }

  public function any(FloatFilterInterface $filter): bool {
    return array_any($this->data, $filter);
  }

  public function clear(): void {
    $this->data = [];
  }

  public function diff(FloatCollectionInterface ...$collections): static {
    return new static(
      ...array_diff(
        $this->data,
        ...array_map(
          static function (FloatCollectionInterface $collection): array {
            return $collection->toArray();
          },
          $collections
        )
      )
    );
  }

  public function filter(FloatFilterInterface $filter): static {
    return new static(...array_filter($this->data, $filter, ARRAY_FILTER_USE_BOTH));
  }

  public function has(float $value): bool {
    return in_array($value, $this->data, true);
  }

  public function intersect(FloatCollectionInterface ...$collections): static {
    return new static(
      ...array_intersect(
        $this->data,
        ...array_map(
          static function (FloatCollectionInterface $collection): array {
            return $collection->toArray();
          },
          $collections
        )
      )
    );
  }

  public function map(FloatMapInterface $map): static {
    return new static(...array_map($map, $this->data));
  }

  public function merge(FloatCollectionInterface ...$collections): self {
    $this->data = array_merge(
      $this->data,
      ...array_map(
        static function (FloatCollectionInterface $collection): array {
          return $collection->toArray();
        },
        $collections
      )
    );

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
