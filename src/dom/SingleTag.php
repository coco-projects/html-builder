<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

class SingleTag extends RawTag
{
    public function __construct(string $tagName = '')
    {
        $templateString = <<<'CONTENTS'
<{:TAG__NAME:} {:ATTRS:} />
CONTENTS;

        parent::__construct($templateString);
        $tagName && $this->appendSubsection('TAG__NAME', $tagName);
    }
    public function afterRender(string &$sectionContents)
    {
    }
}
