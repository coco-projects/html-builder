<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom\tags;

    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\dom\SingleTag;

class Meta extends SingleTag
{
    public function __construct(string|array $kvAttr = [], array $rawAttr = [])
    {
        parent::__construct('meta');
        $this->addAttr('raw', RawAttr::class);
        if (is_array($kvAttr)) {
            $kvAttr = $this->addNativeAttr($kvAttr, $rawAttr);
        }

        $this->getAttr('raw')->setAttrsString($kvAttr);
    }

    public function addNativeAttr(array $kvAttr = [], array $rawAttr = []): string
    {
        $str = [];

        foreach ($kvAttr as $k => $v) {
            $str[] = $k . '="' . strtr((string)$v, ['"' => '\"',]) . '"';
        }

        foreach ($rawAttr as $v) {
            $str[] = $v;
        }

        return implode(' ', $str);
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
