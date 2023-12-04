<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

    use Coco\htmlBuilder\attrs\CustomAttrs;
    use Coco\htmlBuilder\traits\DomEnhancer;

class DomSection extends DomBlock
{
    use DomEnhancer;

    public function __construct(mixed $templateString = '')
    {
        parent::__construct($templateString);
        $this->attrsRegistry = CustomAttrs::ins();
        $this->makeScriptSection();
        $this->makeStyleSection();
        $this->init();
    }

    protected function initAfterSectionRender(): void
    {
        parent::initAfterSectionRender();
    }

    protected function beforeRender(): void
    {
        $this->setSubsections([
            "__CLASS__" => $this->attrsRegistry->evalClass(),
            "__STYLE__" => $this->attrsRegistry->evalStyle(),
            "__ATTRS__" => $this->attrsRegistry->evalAttrs(),
        ]);

        parent::beforeRender();
    }

    protected function afterRender(string &$sectionContents): void
    {
        parent::afterRender($sectionContents);
    }
}
