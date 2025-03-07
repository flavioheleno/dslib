<?php
declare(strict_types = 1);

namespace DsLib\Contract;

interface FloatFilterInterface {
  public function __invoke(float $value, int $index): bool;
}
