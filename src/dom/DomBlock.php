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
     * @var int $nodeId dom 的自增id
     */
    protected static int $nodeId = 0;

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
     * 渲染节点计算完之后，返回之前对值做一些处理
     *
     * @var array $defaultValue
     */
    protected array $afterSectionRender = [];

    /**
     * 当前节点及字节的是否显示
     *
     * @var bool $isHidden
     */
    protected bool $isHidden = false;

    /**
     * @var bool $isDebug
     */
    public static bool $isDebug = true;

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
        "class"       => ClassAttr::class,
        "style"       => StyleAttr::class,
        "id"          => StandardAttr::class,
    ];

    public function __construct(mixed $templateString = '')
    {
        parent::__construct(self::getNodeId());

        if ($this->isRootNode) {
            static::$rootNode = $this;
        }

        $this->setTemplate($templateString);
        $this->initAfterSectionRender();
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
     * 设置节点模板
     *
     * @param mixed $stringable
     *
     * @return $this
     */
    public function setTemplate(mixed $stringable): static
    {
        $this['template'] = $stringable;

        if (is_string($stringable)) {
            $sectionsName = static::extractSectionsName($this['template']);

            foreach ($sectionsName as $k => $sectionName) {
                if (!isset($this['sections'][$sectionName])) {
                    $this['sections'][$sectionName][] = -1;
                }
            }
        }

        return $this;
    }

    /**
     * 追加属性值
     *
     * @param string $sectionName
     * @param mixed  $stringable
     *
     * @return $this
     */
    public function appendSubsection(string $sectionName, mixed $stringable): static
    {
        $node = DomBlock::ins($stringable);

        $this['sections'][$sectionName][] = $node->getId();
        $this->addChild($node);

        return $this;
    }


    /**
     * 设置属性值
     *
     * @param string $sectionName
     * @param mixed  $stringable
     *
     * @return $this
     */
    public function setSubsection(string $sectionName, mixed $stringable): static
    {
        $node = DomBlock::ins($stringable);

        $this['sections'][$sectionName]   = [];
        $this['sections'][$sectionName][] = $node->getId();
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
        foreach ($nodes as $sectionName => $stringable) {
            $this->appendSubsection($sectionName, $stringable);
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
        foreach ($nodes as $sectionName => $stringable) {
            $this->setSubsection($sectionName, $stringable);
        }
        return $this;
    }

    /**
     * 渲染当前节点指定 section
     *
     * @param string $sectionName
     *
     * @return string
     */
    public function renderNodeContents(string $sectionName): string
    {
        if (!isset($this['sectionsContents'][$sectionName])) {
            $this['sectionsContents'][$sectionName] = '';

            $sectionIds = $this['sections'][$sectionName];
            foreach ($sectionIds as $k => $sectionId) {
                if ($sectionId !== -1) {
                    $node = $this->getChildRecrusive($sectionId);

                    $this['sectionsContents'][$sectionName] .= static::evelSectionValue($node['template']);
                }
            }

            if (isset($this->afterSectionRender[$sectionName])) {
                call_user_func_array($this->afterSectionRender[$sectionName], [
                    $sectionName,
                    &$this['sectionsContents'][$sectionName],
                ]);
            }
        }

        return $this['sectionsContents'][$sectionName];
    }

    /**
     * 渲染当前节点
     *
     * @return string
     */

    public function render(): string
    {
        if ($this->isHidden) {
            return '';
        }

        $this->beforeRender();

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
     * 获取 dom 副本
     *
     * @return static
     */
    public function getCopy(): static
    {
        /**
         * @var static $node
         */
        $node = deep_copy($this);

        $node->setId(static::getNodeId());

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
     * 追加指定节点的 section 内容
     *
     * @param DomBlock $node
     * @param string   $sectionName
     * @param mixed    $stringable
     *
     * @return DomBlock
     */
    public function appendDesignatedSection(DomBlock $node, string $sectionName, mixed $stringable): static
    {
        $node->appendSubsection($sectionName, $stringable);

        return $this;
    }


    /**
     * 设置指定节点的 section 内容
     *
     * @param DomBlock $node
     * @param string   $sectionName
     * @param mixed    $stringable
     *
     * @return DomBlock
     */
    public function setDesignatedSection(DomBlock $node, string $sectionName, mixed $stringable): static
    {
        $node->setSubsection($sectionName, $stringable);

        return $this;
    }


    /**
     *
     * 追加顶级节点的 section 内容
     *
     * @param string $sectionName
     * @param mixed  $stringable
     *
     * @return $this
     */
    public function appendRootSection(string $sectionName, mixed $stringable): static
    {
        return $this->appendDesignatedSection(static::$rootNode, $sectionName, $stringable);
    }


    /**
     *
     * 修改顶级节点的 section 内容
     *
     * @param string $sectionName
     * @param mixed  $stringable
     *
     * @return $this
     */
    public function setRootSection(string $sectionName, mixed $stringable): static
    {
        return $this->setDesignatedSection(static::$rootNode, $sectionName, $stringable);
    }

    /**
     * 获取指定 section 对象
     *
     * @param string $sectionName
     *
     * @return mixed
     */
    protected function getSubsection(string $sectionName): mixed
    {
        return $this['sections'][$sectionName];
    }

    /**
     * 计算 section 内容
     *
     * @param mixed $sectionNode
     *
     * @return string
     */
    protected static function evelSectionValue(mixed $sectionNode): string
    {
        $str = '';

        if ($sectionNode instanceof DomBlock) {
            $str = $sectionNode->render();
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
    protected static function getNodeId(): int
    {
        return self::$nodeId++;
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


    /**
     * 渲染节点计算完之后，返回之前对值做一些处理
     *
     * 在字节点中自己定义后写业务逻辑
     *
     */
    protected function initAfterSectionRender(): void
    {
    }

    /**
     * 渲染完成后的回调，子类中完善处理
     * 对js或者css 做mini 操作
     *
     * @param string $sectionContents
     *
     * @return void
     */
    public function afterRender(string &$sectionContents)
    {
    }

    /**
     * 渲染之前回调
     *
     * 在类中自定义方法拼接属性后，在这个回调中调 setSubsection 设置属性
     *
     * @return void
     */
    public function beforeRender()
    {
    }
}
