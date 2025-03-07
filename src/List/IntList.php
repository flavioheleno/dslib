<?php
declare(strict_types = 1);

namespace DsLib\List;

use DsLib\Contract\IntCollectionInterface;
use DsLib\Contract\IntFilterInterface;
use DsLib\Contract\IntMapInterface;
use InvalidArgumentException;

class IntList implements IntCollectionInterface {
  /**
   * @var list<int>
   */
  protected array $data;

  /**
   * @param list<int> $array
   */
  public static function fromArray(array $array): static {
    $invalid = array_filter(
      $array,
      static function (mixed $value): bool {
        return is_int($value) === false;
      }
    );
    if ($invalid !== []) {
      throw new InvalidArgumentException('$array must only contain integer values');
    }

    return new static(...$array);
  }

  public function __construct(int ...$ints) {
    $this->data = $ints;
  }

  public function isEmpty(): bool {
    return $this->data === [];
  }

  /** Array Methods **/
  public function all(IntFilterInterface $filter): bool {
    return array_all($this->data, $filter);
  }

  public function any(IntFilterInterface $filter): bool {
    return array_any($this->data, $filter);
  }

  public function clear(): void {
    $this->data = [];
  }

  public function diff(IntCollectionInterface ...$collections): static {
    return new static(
      ...array_diff(
        $this->data,
        ...array_map(
          static function (IntCollectionInterface $collection): array {
            return $collection->toArray();
          },
          $collections
        )
      )
    );
  }

  public function filter(IntFilterInterface $filter): static {
    return new static(...array_filter($this->data, $filter, ARRAY_FILTER_USE_BOTH));
  }

  public function has(int $value): bool {
    return in_array($value, $this->data, true);
  }

  public function intersect(IntCollectionInterface ...$collections): static {
    return new static(
      ...array_intersect(
        $this->data,
        ...array_map(
          static function (IntCollectionInterface $collection): array {
            return $collection->toArray();
          },
          $collections
        )
      )
    );
  }

  public function map(IntMapInterface $map): static {
    return new static(...array_map($map, $this->data));
  }

  public function merge(IntCollectionInterface ...$collections): self {
    $this->data = array_merge(
      $this->data,
      ...array_map(
        static function (IntCollectionInterface $collection): array {
          return $collection->toArray();
        },
        $collections
      )
    );

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
