<?php
declare(strict_types = 1);

namespace DsLib\Contract;

interface StringMapInterface {
  public function __invoke(string $value): string;
}
