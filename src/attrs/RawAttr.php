<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs;

    use Coco\htmlBuilder\attrs\abstractions\AttributeBaseAbstruct;

class RawAttr extends AttributeBaseAbstruct
{
    public function __construct(string|int $attrsString = '')
    {
        $this->setAttrsString($attrsString);
    }

    /**
     * @return string|int
     */
    public function evalAttrs(): string|int
    {
        return $this->attrsString;
    }
}
