<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

    use Coco\htmlBuilder\attrs\CustomAttrs;
    use Coco\htmlBuilder\dom\tags\CSSCode;
    use Coco\htmlBuilder\dom\tags\JSCode;
    use Coco\htmlBuilder\dom\tags\Link;
    use Coco\htmlBuilder\dom\tags\Meta;
    use Coco\htmlBuilder\dom\tags\Script;
    use Coco\htmlBuilder\dom\tags\Style;
    use Coco\htmlBuilder\traits\DomEnhancer;

class DomSection extends DomBlock
{
    use DomEnhancer;

    public function __construct(mixed $templateString = '')
    {
        parent::__construct($templateString);
        $this->baseCustomAttrsRegistry = CustomAttrs::ins();
        $this->makeScriptSection();
        $this->makeStyleSection();
        $this->init();
    }

    /**
     * 获取自定义属性管理器
     *
     * @return CustomAttrs
     */
    public function getCustomAttrsRegistry(): CustomAttrs
    {
        return $this->baseCustomAttrsRegistry;
    }

    protected function initAfterSectionRender(): void
    {
        parent::initAfterSectionRender();
    }

    protected function beforeRender(): void
    {
        $this->setSubsections([
            "__CLASS__" => $this->getCustomAttrsRegistry()->evalClass(),
            "__STYLE__" => $this->getCustomAttrsRegistry()->evalStyle(),
            "__ATTRS__" => $this->getCustomAttrsRegistry()->evalAttrs(),
        ]);

        parent::beforeRender();
    }

    protected function afterRender(string &$sectionContents): void
    {
        parent::afterRender($sectionContents);
    }
}
