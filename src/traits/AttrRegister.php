<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\traits;

    use Coco\htmlBuilder\attrs\AttrRegistry;
    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;
    use Coco\htmlBuilder\dom\DomBlock;
    use Coco\htmlBuilder\dom\DomSection;
    use Coco\htmlBuilder\dom\tags\CSSCode;
    use Coco\htmlBuilder\dom\tags\JSCode;
    use Coco\htmlBuilder\dom\tags\Link;
    use Coco\htmlBuilder\dom\tags\Meta;
    use Coco\htmlBuilder\dom\tags\Script;
    use Coco\htmlBuilder\dom\tags\Style;

trait AttrRegister
{
    protected ?AttrRegistry $attrRegistry = null;

    /**
     * 常用属性和类型映射
     *
     * @var array|string[] $attrRegistryMap
     */
    protected static array $attrRegistryMap = [
        "href"        => StandardAttr::class,
        "target"      => StandardAttr::class,
        "src"         => StandardAttr::class,
        "alt"         => StandardAttr::class,
        "width"       => StandardAttr::class,
        "height"      => StandardAttr::class,
        "action"      => StandardAttr::class,
        "method"      => StandardAttr::class,
        "type"        => StandardAttr::class,
        "name"        => StandardAttr::class,
        "value"       => StandardAttr::class,
        "rows"        => StandardAttr::class,
        "cols"        => StandardAttr::class,
        "for"         => StandardAttr::class,
        "charset"     => StandardAttr::class,
        "description" => StandardAttr::class,
        "content"     => StandardAttr::class,
        "http_equiv"  => StandardAttr::class,
        "rel"         => StandardAttr::class,
        "base "       => StandardAttr::class,
        "defer"       => StandardAttr::class,
        "async"       => StandardAttr::class,
        "sizes"       => StandardAttr::class,
        "crossorigin" => StandardAttr::class,
        "lang"        => StandardAttr::class,
        "property"    => StandardAttr::class,
        "selected"    => RawAttr::class,
        "disabled"    => RawAttr::class,
        "checked"     => RawAttr::class,
        "class"       => ClassAttr::class,
        "style"       => StyleAttr::class,
        "id"          => StandardAttr::class,
    ];


    protected function initRegistry(): void
    {
        $this->attrRegistry = AttrRegistry::ins();
        $this->getAttr('class');
        $this->getAttr('style');
    }


    /**
     * 注册属性和类型映射表，注册后，getAttr 获取类型时是惰性加载
     *
     * @param string $attrName
     * @param string $attrType
     *
     * @return void
     */
    public static function attrRegister(string $attrName, string $attrType): void
    {
        static::$attrRegistryMap[$attrName] = $attrType;
    }

    /**
     * 获取属性对象
     *
     * @param string $attrName
     *
     * @return ClassAttr|DataAttr|RawAttr|StandardAttr|StyleAttr|null
     */
    public function getAttr(string $attrName): ClassAttr|DataAttr|RawAttr|StandardAttr|StyleAttr|null
    {
        if (!isset($this->attrRegistry->$attrName)) {
            $this->addAttr($attrName, static::$attrRegistryMap[$attrName]);
        }

        return $this->attrRegistry->$attrName;
    }

    /**
     * 添加一个属性对象
     *
     * @param string $attrName
     * @param string $attrType
     *
     * @return $this
     */
    public function addAttr(string $attrName, string $attrType): static
    {
        $this->attrRegistry->$attrName = $attrType;

        return $this;
    }


    /**
     * 获取结构化属性管理器
     *
     * @return AttrRegistry
     */
    public function getAttrRegistry(): AttrRegistry
    {
        return $this->attrRegistry;
    }
}
