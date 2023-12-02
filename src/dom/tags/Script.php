<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom\tags;

    use Coco\htmlBuilder\dom\DoubleTag;
    use MatthiasMullie\Minify\CSS;
    use MatthiasMullie\Minify\JS;

class Script extends DoubleTag
{
    public function __construct()
    {
        parent::__construct('script');
    }

    public function link(string $link):static
    {
        $this->inner(function (DoubleTag $this_, array &$inner) use (&$link) {
            $this_->getAttr('src')->setAttrKv('src', $link);
            $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
        });

        return $this;
    }

    public function rawCode(string|JSCode $code):static
    {
        $this->setInnerContents($code);

        return $this;
    }


    /**
     * 渲染节点计算完之后，返回之前对值做一些处理
     *
     * 在字节点中自己定义后写业务逻辑
     *
     */
    protected function initAfterSectionRender(): void
    {
        parent::initAfterSectionRender();
    }

    /**
     * 渲染完成后的回调，子类中完善处理
     * 对js或者css 做mini 操作
     *
     * @param string $sectionContents
     *
     * @return void
     */
    protected function afterRender(string &$sectionContents): void
    {
        if (!$this::$isDebug) {
            $minifier = new JS();
            $minifier->add($sectionContents);
            $sectionContents = $minifier->minify();
        }
        parent::afterRender($sectionContents);
    }

    /**
     * 渲染之前回调
     *
     * 在类中自定义方法拼接属性后，在这个回调中调 setSubsection 设置属性
     *
     * @return void
     */
    protected function beforeRender(): void
    {
        parent::beforeRender();
    }
}
