<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs;

    use Coco\htmlBuilder\attrs\abstractions\ArrayAttributeAbstruct;

class ClassAttr extends ArrayAttributeAbstruct
{
    public function __construct(array $attrsArray = [])
    {
        parent::__construct($attrsArray);
        $this->setKey('class');
    }

    /**
     * @return string
     */
    protected function toValueString(): string
    {
        return implode(' ', $this->getAttrs());
    }


    public function beforeGetAttrsString(string &$str): void
    {
        $str = preg_replace('/(")$/im', ' {:__CLASS__:}$1', $str);
    }
}
