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

    public function afterRender(string &$sectionContents)
    {
    }
}
