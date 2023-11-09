<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

class RawTag extends DomBlock
{
    public function __construct(string $templateString = '')
    {
        parent::__construct($templateString);
        $this->appendSubsection('ATTRS', $this['attrRegistry']);
    }
}
