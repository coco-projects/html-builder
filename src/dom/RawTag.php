<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

    use Coco\htmlBuilder\attrs\AttrRegistry;
    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\CustomAttrs;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;
    use Coco\htmlBuilder\traits\AttrRegister;
    use Coco\htmlBuilder\traits\DomEnhancer;

class RawTag extends DomBlock
{
    use DomEnhancer;
    use AttrRegister;

    public function __construct(string $templateString = '')
    {
        parent::__construct($templateString);
        $this->initRegistry();
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
        //生成这两个对象，否则不会生成属性

        $this->getAttr('class')->setBeforeGetValueCallback(function (&$str) {
            if (!$str) {
                $str = '"{:__CLASS__:}"';
            } else {
                $str = preg_replace('/(")$/im', '{:__CLASS__:}$1', $str);
            }
        });

        $this->getAttr('style')->setBeforeGetValueCallback(function (&$str) {
            if (!$str) {
                $str = '"{:__STYLE__:}"';
            } else {
                $str = preg_replace('/(")$/im', '{:__STYLE__:}$1', $str);
            }
        });

        $this->attrRegistry->setBeforeGetValueCallback(function (&$str) {
            $str .= ' {:__ATTRS__:}';
        });

        $attrString = (string)$this->attrRegistry;

        $node = DomBlock::ins($attrString);

        $node->setSubsections([
            "__CLASS__" => $this->getCustomAttrsRegistry()->evalClass(),
            "__STYLE__" => $this->getCustomAttrsRegistry()->evalStyle(),
            "__ATTRS__" => $this->getCustomAttrsRegistry()->evalAttrs(),
        ]);

        $this->appendSubsection('ATTRS', $node);

        parent::beforeRender();
    }

    protected function afterRender(string &$sectionContents): void
    {
        parent::afterRender($sectionContents);
    }
}
