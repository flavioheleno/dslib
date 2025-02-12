<?php
declare(strict_types = 1);

namespace DsLib\Set;

use DsLib\Contract\FloatCollectionInterface;
use DsLib\List\FloatList;

class FloatSet extends FloatList {
  public function __construct(float ...$values) {
    $this->data = [];

    foreach ($values as $value) {
      $this->push($value);
    }
  }

  /** Array Methods **/
  public function merge(FloatCollectionInterface ...$collections): self {
    foreach ($collections as $collection) {
      foreach ($collection as $value) {
        $this->push($value);
      }
    }

    return $this;
  }

  public function push(float $value): self {
    if ($this->has($value) === true) {
      return $this;
    }

    array_push($this->data, $value);

    return $this;
  }

  public function unshift(float $value): self {
    if ($this->has($value) === true) {
      return $this;
    }

    array_unshift($this->data, $value);

    return $this;
  }
}
