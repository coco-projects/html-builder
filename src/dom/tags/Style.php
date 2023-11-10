<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom\tags;

    use Coco\htmlBuilder\dom\DoubleTag;
    use MatthiasMullie\Minify\CSS;

class Style extends DoubleTag
{
    public function __construct(string|CSSCode $code = '')
    {
        parent::__construct('style');
        $this->process(function (DoubleTag $this_, array &$inner) use (&$code) {
            $inner[] = $code;
        });
    }

    public function afterRender(string &$sectionContents)
    {
        if (!$this::$isDebug) {
            $minifier = new CSS();
            $minifier->add($sectionContents);
            $sectionContents = $minifier->minify();
        }
    }
}
