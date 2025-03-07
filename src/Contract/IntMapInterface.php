<?php
declare(strict_types = 1);

namespace DsLib\Contract;

interface IntMapInterface {
  public function __invoke(int $value): int;
}
