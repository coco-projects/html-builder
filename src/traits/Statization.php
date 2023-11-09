<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\traits;

trait Statization
{
    public static function ins(): static
    {
        return new static(...func_get_args());
    }
}
