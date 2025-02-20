<?php
declare(strict_types = 1);

namespace DsLib\List;

use DsLib\Contract\StringCollectionInterface;
use InvalidArgumentException;

class StringList implements StringCollectionInterface {
  /**
   * @var list<string>
   */
  protected array $data;

  /**
   * @param list<string> $array
   */
  public static function fromArray(array $array): static {
    $invalid = array_filter(
      $array,
      static function (mixed $value): bool {
        return is_string($value) === false;
      }
    );
    if ($invalid !== []) {
      throw new InvalidArgumentException('$array must only contain string values');
    }

    return new static(...$array);
  }

  public function __construct(string ...$strings) {
    $this->data = $strings;
  }

  public function isEmpty(): bool {
    return $this->data === [];
  }

  /** Array Methods **/

  /**
   * @param callable(string,int):bool $callback
   */
  public function all(callable $callback): bool {
    return array_all($this->data, $callback);
  }

  /**
   * @param callable(string,int):bool $callback
   */
  public function any(callable $callback): bool {
    return array_any($this->data, $callback);
  }

  public function clear(): void {
    $this->data = [];
  }

  public function diff(StringCollectionInterface ...$collections): static {
    return new static(
      ...array_diff(
        $this->data,
        ...array_map(
          static function (StringCollectionInterface $collection): array {
            return $collection->toArray();
          },
          $collections
        )
      )
    );
  }

  /**
   * @param callable(string):bool $callback
   */
  public function filter(callable $callback): static {
    return new static(...array_filter($this->data, $callback));
  }

  public function has(string $value): bool {
    return in_array($value, $this->data, true);
  }

  public function intersect(StringCollectionInterface ...$collections): static {
    return new static(
      ...array_intersect(
        $this->data,
        ...array_map(
          static function (StringCollectionInterface $collection): array {
            return $collection->toArray();
          },
          $collections
        )
      )
    );
  }

  public function join(string $separator): string {
    return implode($separator, $this->data);
  }

  /**
   * @param callable(int):bool $callback
   */
  public function map(callable $callback): static {
    return new static(...array_map($callback, $this->data));
  }

  public function merge(StringCollectionInterface ...$collections): self {
    $this->data = array_merge(
      $this->data,
      ...array_map(
        static function (StringCollectionInterface $collection): array {
          return $collection->toArray();
        },
        $collections
      )
    );

    return $this;
  }

  public function pop(): string {
    return (string)array_pop($this->data);
  }

  public function push(string $value): self {
    array_push($this->data, $value);

    return $this;
  }

  public function rsort(): void {
    rsort($this->data, SORT_STRING);
  }

  public function shift(): string {
    return (string)array_shift($this->data);
  }

  public function slice(int $offset, int|null $length = null): static {
    return new static(...array_slice($this->data, $offset, $length));
  }

  public function sort(): void {
    sort($this->data, SORT_STRING);
  }

  public function unique(): static {
    return new static(...array_unique($this->data, SORT_STRING));
  }

  public function unshift(string $value): self {
    array_unshift($this->data, $value);

    return $this;
  }

  /**
   * @return list<string>
   */
  public function toArray(): array {
    return $this->data;
  }

  /** Countable **/
  public function count(): int {
    return count($this->data);
  }

  /** Iterator **/
  public function current(): string {
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
