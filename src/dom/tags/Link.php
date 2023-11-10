<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom\tags;

    use Coco\htmlBuilder\dom\SingleTag;

class Link extends SingleTag
{
    public function __construct(string $link)
    {
        parent::__construct('link');
        $this->process(function (SingleTag $this_, array &$inner) use (&$link) {
            $this_->getAttr('href')->setAttrKv('href', $link);
            $this_->getAttr('rel')->setAttrKv('rel', 'stylesheet');
            $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
        });
    }

    public function afterRender(string &$sectionContents)
    {
    }
}
