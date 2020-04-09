<?php

namespace Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Collection;

trait CommonTrait
{
    private static function map(array $items, callable $function): Collection
    {
        return Collection::make($items)->map($function);
    }
}
