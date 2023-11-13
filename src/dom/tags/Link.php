<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom\tags;

    use Coco\htmlBuilder\dom\SingleTag;

class Link extends SingleTag
{
    public function __construct(string $link)
    {
        parent::__construct('link');
        $this->process(function (SingleTag $this_, array &$inner) use (&$link) {
            $this_->getAttr('href')->setAttrKv('href', $link);
            $this_->getAttr('rel')->setAttrKv('rel', 'stylesheet');
            $this_->getAttr('crossorigin')->setAttrKv('crossorigin', 'anonymous');
        });
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
