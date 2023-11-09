<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

class DomSection extends DomBlock
{
    private static array $valueMap = [];

    /**
     *head 中的自定义 js 代码对象
     *
     * @var DomSection|null $scriptSection
     */
    protected ?DomSection $scriptSection = null;

    /**
     *head 中的自定义css代码对象
     *
     * @var DomSection|null $styleSection
     */
    protected ?DomSection $styleSection = null;

    public function __construct(string $templateString = '')
    {
        parent::__construct($templateString);
        $this->appendSubsection('ATTRS', $this['attrRegistry']);
        $this->makeScriptSection();
        $this->makeStyleSection();
        $this->init();
    }


    /**
     * head 中的js 链接
     *
     * @param string $link
     * @param bool   $isUnique
     *
     * @return $this
     */
    public function jsHead(string $link, bool $isUnique = true): static
    {
        $uniqueLabel = md5($link);
        if (!$isUnique || !isset(self::$valueMap[$uniqueLabel])) {
            self::$valueMap[$uniqueLabel] = 1;
            $this->appendParentSection('JS_HEAD', [
                DoubleTag::ins('script')->process(function (DoubleTag $this_, array &$inner) use (&$link) {
                    $this_->getAttr('src')->setAttrKv('src', $link);
                    $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
                }),
            ]);
        }

        return $this;
    }

    /**
     * body 中的 js 链接
     *
     * @param string $link
     * @param bool   $isUnique
     *
     * @return $this
     */
    public function jsLib(string $link, bool $isUnique = true): static
    {
        $uniqueLabel = md5($link);
        if (!$isUnique || !isset(self::$valueMap[$uniqueLabel])) {
            self::$valueMap[$uniqueLabel] = 1;
            $this->appendParentSection('JS_LIB', [
                DoubleTag::ins('script')->process(function (DoubleTag $this_, array &$inner) use (&$link) {
                    $this_->getAttr('src')->setAttrKv('src', $link);
                    $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
                }),
            ]);
        }

        return $this;
    }

    /**
     * body 中的 js 调用代码，适用于代码不需要替换变量的场景，可设定每次调用追加与否
     *
     * @param string $codeWithScriptTag
     * @param bool   $isUnique
     *
     * @return $this
     */
    public function jsCustomRawCode(string $codeWithScriptTag, bool $isUnique = true): static
    {
        $uniqueLabel = md5($codeWithScriptTag);
        if (!$isUnique || !isset(self::$valueMap[$uniqueLabel])) {
            self::$valueMap[$uniqueLabel] = 1;
            $this->appendParentSection('JS_CUSTOM', $codeWithScriptTag);
        }

        return $this;
    }

    /**
     * body 中的 js 调用代码，适用于复杂代码需要替换的场景，每次调用会追加一次
     *
     * @param DomBlock $section
     *
     * @return $this
     */
    public function jsCustomDomSection(DomBlock $section): static
    {
        $this->appendParentSection('JS_CUSTOM', $section);

        return $this;
    }


    /**
     * head 中的 css 链接
     *
     * @param string $link
     * @param bool   $isUnique
     *
     * @return $this
     */
    public function cssLib(string $link, bool $isUnique = true): static
    {
        $uniqueLabel = md5($link);
        if (!$isUnique || !isset(self::$valueMap[$uniqueLabel])) {
            self::$valueMap[$uniqueLabel] = 1;
            $this->appendParentSection('CSS_LIB', [
                SingleTag::ins('link')->process(function (SingleTag $this_, array &$inner) use (&$link) {
                    $this_->getAttr('href')->setAttrKv('href', $link);
                    $this_->getAttr('rel')->setAttrKv('rel', 'stylesheet');
                    $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
                }),
            ]);
        }

        return $this;
    }

    /**
     * head 中的自定义css代码
     *
     * @param string $codeWithStyleTag
     * @param bool   $isUnique
     *
     * @return $this
     */
    public function cssCustomRawCode(string $codeWithStyleTag, bool $isUnique = true): static
    {
        $uniqueLabel = md5($codeWithStyleTag);
        if (!$isUnique || !isset(self::$valueMap[$uniqueLabel])) {
            self::$valueMap[$uniqueLabel] = 1;
            $this->appendParentSection('CSS_CUSTOM', $codeWithStyleTag);
        }

        return $this;
    }


    /**
     * 获取底部自定义的 js 模板对象
     *
     * @return DomSection|null
     */
    public function getScriptSection(): ?DomSection
    {
        return $this->scriptSection;
    }

    /**
     * 构造器中自动初始化当前页面的js模板对象
     * 其中的逻辑应该是定义一个匿名类，继承 DomSection，然后把类赋值给 $this->scriptSection
     *
     * @return void
     */
    protected function makeScriptSection(): void
    {
    }

    /**
     * 构造器中自动初始化当前页面的css模板对象
     * 其中的逻辑应该是定义一个匿名类，继承 DomSection，然后把类赋值给 $this->styleSection
     *
     * @return void
     */
    protected function makeStyleSection(): void
    {
    }

    /**
     * 构造器中自动初始化
     * 适用于调用 cssLib，jsLib
     *
     * @return void
     */
    protected function init(): void
    {
    }
}
