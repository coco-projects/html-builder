<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\dom\tags;

    use Coco\htmlBuilder\attrs\RawAttr;
    use Coco\htmlBuilder\dom\SingleTag;

class Meta extends SingleTag
{
    public array $str = [];

    public function __construct()
    {
        parent::__construct('meta');
        $this->addAttr('raw', RawAttr::class);
    }

    /**
     * @param array $kvAttr
     *
     *      [
     * "name"    => "viewport",
     * "content" => "width=device-width, initial-scale=1",
     * ]
     *
     *
     * @return $this
     */
    public function addKvAttr(array $kvAttr): static
    {
        $str = [];

        foreach ($kvAttr as $k => $v) {
            $str[] = $k . '="' . strtr((string)$v, ['"' => '\"',]) . '"';
        }

        $this->str = array_merge($this->str, $str);

        return $this;
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
    public function afterRender(string &$sectionContents): void
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
    public function beforeRender(): void
    {
        $this->getAttr('raw')->setAttrsString(implode(' ', $this->str));
        parent::beforeRender();
    }
}
