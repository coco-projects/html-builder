<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

    use Coco\htmlBuilder\attrs\CustomAttrs;
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
            "__CLASS__" => $this->attrsRegistry->evalClass(),
            "__STYLE__" => $this->attrsRegistry->evalStyle(),
            "__ATTRS__" => $this->attrsRegistry->evalAttrs(),
        ]);

        $this->appendSubsection('ATTRS', $node);

        parent::beforeRender();
    }

    protected function afterRender(string &$sectionContents): void
    {
        parent::afterRender($sectionContents);
    }
}
