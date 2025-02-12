<?php
declare(strict_types = 1);

namespace DsLib\Set;

use DsLib\Contract\IntCollectionInterface;
use DsLib\List\IntList;

class IntSet extends IntList {
  public function __construct(int ...$values) {
    $this->data = [];

    foreach ($values as $value) {
      $this->push($value);
    }
  }

  /** Array Methods **/
  public function merge(IntCollectionInterface ...$collections): self {
    foreach ($collections as $collection) {
      foreach ($collection as $value) {
        $this->push($value);
      }
    }

    return $this;
  }

  public function push(int $value): self {
    if ($this->has($value) === true) {
      return $this;
    }

    array_push($this->data, $value);

    return $this;
  }

  public function unshift(int $value): self {
    if ($this->has($value) === true) {
      return $this;
    }

    array_unshift($this->data, $value);

    return $this;
  }
}
