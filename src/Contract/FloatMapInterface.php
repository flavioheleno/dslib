<?php
declare(strict_types = 1);

namespace DsLib\Contract;

interface FloatMapInterface {
  public function __invoke(float $value): float;
}
