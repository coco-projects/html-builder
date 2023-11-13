<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

use Coco\htmlBuilder\attrs\AttrRegistry;

class RawTag extends DomBlock
{
    public function __construct(string $templateString = '')
    {
        parent::__construct($templateString);
        $this['attrRegistry'] = AttrRegistry::ins();
        $this->appendSubsection('ATTRS', $this['attrRegistry']);
    }
}
