<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs;

    use Coco\htmlBuilder\attrs\abstractions\KVAttributeAbstruct;

class StyleAttr extends KVAttributeAbstruct
{
    public function __construct(array $attrsArray = [])
    {
        parent::__construct($attrsArray);
        $this->setKey('style');
    }

    /**
     * @return string
     */
    protected function getTemplate(): string
    {
        return '__KEY__:__VALUE__;';
    }
}
