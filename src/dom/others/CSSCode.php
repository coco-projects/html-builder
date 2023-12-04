<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom\others;

    use Coco\htmlBuilder\dom\DomSection;
    use MatthiasMullie\Minify\CSS;

class CSSCode extends DomSection
{
    public function __construct(string $code = '')
    {
        parent::__construct($code);
    }

    protected function afterRender(string &$sectionContents): void
    {
        if (!$this::$isDebug) {
            $minifier = new CSS();
            $minifier->add($sectionContents);
            $sectionContents = $minifier->minify();
        }
    }
}
