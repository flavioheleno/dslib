<?php
declare(strict_types = 1);

namespace DsLib\Set;

use DsLib\Contract\StringCollectionInterface;
use DsLib\List\StringList;

class StringSet extends StringList {
  public function __construct(string ...$strings) {
    $this->data = [];

    foreach ($strings as $string) {
      $this->push($string);
    }
  }

  /** Array Methods **/
  public function merge(StringCollectionInterface $set): self {
    foreach ($set as $string) {
      $this->push($string);
    }

    return $this;
  }

  public function push(string $value): self {
    if ($this->has($value) === true) {
      return $this;
    }

    array_push($this->data, $value);

    return $this;
  }

  public function unshift(string $value): self {
    if ($this->has($value) === true) {
      return $this;
    }

    array_unshift($this->data, $value);

    return $this;
  }
}
