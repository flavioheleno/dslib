<?php
declare(strict_types = 1);

namespace DsLib\Contract;

interface StringFilterInterface {
  public function __invoke(string $value, int $index): bool;
}
