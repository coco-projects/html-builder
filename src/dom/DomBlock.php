<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom;

    use Coco\htmlBuilder\attrs\AttrRegistry;
    use Coco\htmlBuilder\attrs\ClassAttr;
    use Coco\htmlBuilder\attrs\DataAttr;
    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\attrs\StandardAttr;
    use Coco\htmlBuilder\attrs\StyleAttr;
    use Coco\htmlBuilder\traits\Statization;
    use Coco\magicAccess\MagicMethod;
    use Coco\tree\TreeNode;
    use function DeepCopy\deep_copy;

class DomBlock extends TreeNode
{
    use Statization;
    use MagicMethod;

    /**
     * @var mixed|array $var 各个组件中间共享变量
     */
    public static mixed $var = [];

    /**
     * @var int $sectionId dom 的自增id
     */
    protected static int $sectionId = 0;

    /**
     * @var array $commonAttrs 顶级允许被子级修改的节点值，一般只有 Document 使用
     */
    protected array $commonAttrs = [];

    /**
     * @var bool $isRootNode 是否为顶级节点，一般只有 Document 使用
     */
    protected bool $isRootNode = false;

    /**
     * @var DomBlock|null $rootNode 顶级节点对象，一般只有 Document 使用
     */
    protected static ?DomBlock $rootNode = null;

    /**
     * 节点默认值，实例化时候自动填充
     *
     * @var array $defaultValue
     */
    protected array $defaultValue = [];

    /**
     * @var bool $isHidden
     */
    protected bool $isHidden = false;

    /**
     * @var bool $isDebug
     */
    public static bool $isDebug = true;

    /**
     * @var array|string[] $attrRegistryMap 常用属性和类型映射
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
        "class"       => ClassAttr::class,
        "style"       => StyleAttr::class,
        "id"          => StandardAttr::class,
    ];

    public function __construct(mixed $templateString = '')
    {
        parent::__construct(self::getSectionId());

        if ($this->isRootNode) {
            static::$rootNode = $this;
        }

        $this['attrRegistry'] = AttrRegistry::ins();
        $this->setTemplate($templateString);
        $this->initDefault();
    }

    /**
     * @param bool $isHidden
     *
     * @return DomBlock
     */
    public function setIsHidden(bool $isHidden): static
    {
        $this->isHidden = $isHidden;

        return $this;
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
        if (!isset($this['attrRegistry']->$attrName)) {
            $this->addAttr($attrName, static::$attrRegistryMap[$attrName]);
        }

        return $this['attrRegistry']->$attrName;
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
        $this['attrRegistry']->$attrName = $attrType;

        return $this;
    }


    /**
     * 获取属性管理器
     *
     * @return AttrRegistry
     */
    public function getAttrRegistry(): AttrRegistry
    {
        return $this['attrRegistry'];
    }

    /**
     * 设置模板
     *
     * @param mixed $stringable
     *
     * @return $this
     */
    public function setTemplate(mixed $stringable): static
    {
        $this['template'] = $stringable;

        if (is_string($this['template'])) {
            $nodesName = static::extractSectionsName($this['template']);

            foreach ($nodesName as $k => $nodeName) {
                if (!isset($this['sections'][$nodeName])) {
                    $this['sections'][$nodeName][] = -1;
                }
            }
        }

        return $this;
    }

    /**
     * 追加属性值
     *
     * @param string $nodeName
     * @param mixed  $stringable
     *
     * @return $this
     */
    public function appendSubsection(string $nodeName, mixed $stringable): static
    {
        $node = DomBlock::ins($stringable);

        $this['sections'][$nodeName][] = $node->getId();
        $this->addChild($node);

        return $this;
    }


    /**
     * 设置属性值
     *
     * @param string $nodeName
     * @param mixed  $stringable
     *
     * @return $this
     */
    public function setSubsection(string $nodeName, mixed $stringable): static
    {
        $node                          = DomBlock::ins($stringable);
        $this['sections'][$nodeName]   = [];
        $this['sections'][$nodeName][] = $node->getId();
        $this->addChild($node);

        return $this;
    }


    /**
     * 批量追加属性值
     *
     * @param array $nodes
     *
     * @return $this
     */
    public function appendSubsections(array $nodes): static
    {
        foreach ($nodes as $nodeName => $stringable) {
            $this->appendSubsection($nodeName, $stringable);
        }
        return $this;
    }

    /**
     * 批量设置属性值
     *
     * @param array $nodes
     *
     * @return $this
     */
    public function setSubsections(array $nodes): static
    {
        foreach ($nodes as $nodeName => $stringable) {
            $this->setSubsection($nodeName, $stringable);
        }
        return $this;
    }

    /**
     * 渲染模板
     *
     * @return string
     */

    public function render(): string
    {
        if ($this->isHidden) {
            return '';
        }

        $template  = $this['template'];
        $toReplace = [];

        foreach ($this['sections'] as $sectionName => $sectionIds) {
            $toReplace[static::makeNodeName($sectionName)] = $this->renderNodeContents($sectionName);
        }

        $contents = strtr($template, $toReplace);

        $this->afterRender($contents);

        return $contents;
    }

    /**
     * 渲染完成后的回调，子类中完善处理
     *
     * @param string $sectionContents
     *
     * @return void
     */
    public function afterRender(string &$sectionContents)
    {
    }

    public function renderNodeContents(string $sectionName): string
    {
        if (!isset($this['sectionsContents'][$sectionName])) {
            $this['sectionsContents'][$sectionName] = '';

            $sectionIds = $this['sections'][$sectionName];
            foreach ($sectionIds as $k => $sectionId) {
                if ($sectionId !== -1) {
                    $node = $this->getChildRecrusive($sectionId);

                    $this['sectionsContents'][$sectionName] .= static::evelSectionValue($node['template']);
                    ;
                }
            }
        }

        return $this['sectionsContents'][$sectionName];
    }

    /**
     * 获取dom副本
     *
     * @return static
     */
    public function getCopy(): static
    {
        /**
         * @var static $node
         */
        $node = deep_copy($this);

        $node->setId(static::getSectionId());

        return $node;
    }

    /**
     * 转为回调方式处理
     *
     * @param callable $callback
     *
     * @return $this
     */
    public function process(callable $callback): static
    {
        $contents = [];

        call_user_func_array($callback, [
            $this,
            &$contents,
        ]);

        $this->setInnerContents($contents);

        return $this;
    }

    /**
     * 设置内部内容，填充 INNER_CONTENTS 节点
     *
     * @param mixed $innerContents
     *
     * @return $this
     */
    public function setInnerContents(mixed $innerContents): static
    {
        return $this->appendSubsection('INNER_CONTENTS', $innerContents);
    }


    /**
     * 修改顶级节点内容
     *
     * @param string $nodeName
     * @param mixed  $stringable
     *
     * @return $this
     */
    public function appendParentSection(string $nodeName, mixed $stringable): static
    {
        if (in_array($nodeName, static::$rootNode->commonAttrs)) {
            static::$rootNode->appendSubsection($nodeName, $stringable);
        }

        return $this;
    }

    /**
     * 获取指定分块对象
     *
     * @param string $nodeName
     *
     * @return mixed
     */
    protected function getSubsection(string $nodeName): mixed
    {
        return $this['sections'][$nodeName];
    }

    /**
     * 计算
     *
     * @param mixed $sectionNode
     *
     * @return string
     */
    protected static function evelSectionValue(mixed $sectionNode): string
    {
        $str = '';

        if ($sectionNode instanceof DomBlock) {
            if (!isset($sectionNode['cache'])) {
                $sectionNode['cache'] = $sectionNode->render();
            }

            $str = $sectionNode['cache'];
        } elseif (is_string($sectionNode)) {
            $str = $sectionNode;
        } elseif (is_array($sectionNode)) {
            $str_ = [];

            foreach ($sectionNode as $k => $v) {
                $str_[] = static::evelSectionValue($v);
            }

            $str = implode('', $str_);
        } elseif (is_callable($sectionNode)) {
            $str = call_user_func_array($sectionNode, []);
        } else {
            $str = (string)$sectionNode;
        }

        return $str;
    }

    /**
     * @param string $tag
     *
     * @return string
     */
    protected static function makeNodeName(string $tag): string
    {
        return "{:$tag:}";
    }


    /**
     * 构造器中填充默认值
     *
     * @return void
     */
    protected function initDefault(): void
    {
        $this->setSubsections($this->defaultValue);
    }

    /**
     * @return int
     */
    protected static function getSectionId(): int
    {
        return self::$sectionId++;
    }

    /**
     * @param string $templateString
     *
     * @return array
     */
    protected static function extractSectionsName(string $templateString): array
    {
        preg_match_all('/\{\:([a-z\d_]+)\:\}/im', $templateString, $result);

        return $result[1];
    }
}
