<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom\tags;

    use Coco\htmlBuilder\dom\DoubleTag;
    use MatthiasMullie\Minify\CSS;
    use MatthiasMullie\Minify\JS;

class Script extends DoubleTag
{
    public function __construct(string|JSCode $codeOrLink = '', bool $isRemoteScript = true)
    {
        parent::__construct('script');

        if ($isRemoteScript) {
            $this->process(function (DoubleTag $this_, array &$inner) use (&$codeOrLink) {
                $this_->getAttr('src')->setAttrKv('src', $codeOrLink);
                $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
            });
        } else {
            $this->process(function (DoubleTag $this_, array &$inner) use (&$codeOrLink) {
                $inner[] = $codeOrLink;
            });
        }
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
