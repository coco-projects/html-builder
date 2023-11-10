<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom\tags;

    use Coco\htmlBuilder\dom\DomSection;
    use MatthiasMullie\Minify\JS;

class JSCode extends DomSection
{
    public function __construct(string $code = '')
    {
        parent::__construct($code);
    }

    public function afterRender(string &$sectionContents)
    {
        if (!$this::$isDebug) {
            $minifier = new JS();
            $minifier->add($sectionContents);
            $sectionContents = $minifier->minify();
        }
    }
}
