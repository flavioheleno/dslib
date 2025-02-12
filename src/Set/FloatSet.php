<?php
declare(strict_types = 1);

namespace DsLib\Set;

use DsLib\Contract\FloatCollectionInterface;
use DsLib\List\FloatList;

class FloatSet extends FloatList {
  public function __construct(float ...$floats) {
    $this->data = [];

    foreach ($floats as $float) {
      $this->push($float);
    }
  }

  /** Array Methods **/
  public function merge(FloatCollectionInterface $set): self {
    foreach ($set as $float) {
      $this->push($float);
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
