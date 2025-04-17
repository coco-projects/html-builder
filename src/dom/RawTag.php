<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

    use Coco\htmlBuilder\attrs\CustomAttrs;
    use Coco\htmlBuilder\traits\AttrRegister;
    use Coco\htmlBuilder\traits\DomEnhancer;

    class RawTag extends DomBlock
    {
        use DomEnhancer;

        //标签结构化的属性
        use AttrRegister;

        //标签自由化属性
        public CustomAttrs $attrsRegistry;

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
            $this->getAttr('class')->setBeforeGetValueCallback(function(&$str) {
                $str = trim($str);
                if ($str)
                {
                    $str = preg_replace('/(")$/im', '__CLASS__$1', $str);
                }
            });

            $this->getAttr('style')->setBeforeGetValueCallback(function(&$str) {
                $str = trim($str);
                if ($str)
                {
                    $str = preg_replace('/(")$/im', ' __STYLE__$1', $str);
                }
            });

            $this->attrRegistry->setBeforeGetValueCallback(function(&$str) {
                $str .= ' {:__ATTRS__:}';
                $str = trim($str);
            });

            //构造结构化的属性
            $attrString = (string)$this->attrRegistry;

            $classes = $this->attrsRegistry->evalClass();
            //构造非结构化的属性
            $attrString = strtr($attrString, [
                "__CLASS__" => $classes ? ' ' . $classes : '',
                "__STYLE__" => $this->attrsRegistry->evalStyle(),
            ]);

            //如果class或者style是空，删除这两个属性
            $attrString = preg_replace('/style\s*="\s*"/im', '', $attrString);
            $attrString = preg_replace('/class\s*="\s*"/im', '', $attrString);

            $node = DomBlock::ins($attrString);
            $node->setSubsections([
                "__ATTRS__" => trim($this->attrsRegistry->evalAttrs()),
            ]);

            $this->appendSubsection('ATTRS', $node);

            parent::beforeRender();
        }

        protected function afterRender(string &$sectionContents): void
        {
            $sectionContents = preg_replace('/\s*"\s+>/im', '">', $sectionContents);
            $sectionContents = preg_replace('/\s+>/im', '>', $sectionContents);

            parent::afterRender($sectionContents);
        }
    }
