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
     * @param string|int $attrsString
     *
     * @return RawAttr
     */
    public function setAttrsString(string|int $attrsString): RawAttr
    {
        $this->attrsString = $attrsString;

        return $this;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return (string)$this->attrsString;
    }
}
