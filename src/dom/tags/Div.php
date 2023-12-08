<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom\tags;

    use Coco\htmlBuilder\dom\DoubleTag;

class Div extends DoubleTag
{
    public function __construct()
    {
        parent::__construct('div');
    }

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
