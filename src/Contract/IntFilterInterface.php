<?php
declare(strict_types = 1);

namespace DsLib\Contract;

interface IntFilterInterface {
  public function __invoke(int $value, int $index): bool;
}
