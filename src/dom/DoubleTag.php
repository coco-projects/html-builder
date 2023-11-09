<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

class DoubleTag extends RawTag
{
    public function __construct(string $tagName = '', mixed $innerContents = '')
    {
        $templateString = <<<'CONTENTS'
<{:TAG__NAME:} {:ATTRS:} >{:INNER_CONTENTS:}</{:TAG__NAME:}>
CONTENTS;
        parent::__construct($templateString);
        $tagName && $this->tagName($tagName);
        $innerContents && $this->setInnerContents($innerContents);
    }

    /**
     * @param string $tagName
     *
     * @return $this
     */
    public function tagName(string $tagName): static
    {
        return $this->appendSubsection('TAG__NAME', $tagName);
    }
}
