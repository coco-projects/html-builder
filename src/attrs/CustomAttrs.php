<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs;

    use Coco\htmlBuilder\traits\AttrRegister;
    use Coco\htmlBuilder\traits\Statization;
    use Coco\magicAccess\MagicMethod;

class CustomAttrs
{
    use Statization;
    use MagicMethod;
    use AttrRegister;

    public array $attrsLabes = [];

    public function __construct()
    {
        $this->initRegistry();
    }

    /*
     * ------------------------------------------------------
     * ------------------------------------------------------
     */

    public function appendClass(string $class): static
    {
        $this->getAttr('class')->addAttr($class);

        return $this;
    }

    public function appendClassArr(array $classes): static
    {
        $this->getAttr('class')->addAttrsArray($classes);

        return $this;
    }

    public function hasClass(string $class): bool
    {
        return $this->getAttr('class')->hasAttr($class);
    }

    public function removeClass(string $class): static
    {
        $this->getAttr('class')->removeAttr($class);

        return $this;
    }

    public function getAllClass(): array
    {
        return $this->getAttr('class')->getAttrs();
    }

    public function clearClass(): static
    {
        $this->getAttr('class')->clearValue();

        return $this;
    }


    /*
     * ------------------------------------------------------
     * ------------------------------------------------------
     */
    public function removeAttr(string $attrString): static
    {
        unset($this->attrsLabes[$attrString]);

        return $this;
    }

    public function hasAttr(string $attrString): bool
    {
        return isset($this->attrsLabes[$attrString]);
    }

    public function appendAttrRaw(string $attrString): static
    {
        $this->attrsLabes[$attrString]   = 1;
        $this->attrRegistry->$attrString = RawAttr::class;
        $this->attrRegistry->$attrString->setAttrsString($attrString);

        return $this;
    }


    public function appendAttrRawArr(array $attrStrings): static
    {
        foreach ($attrStrings as $k => $v) {
            $this->appendAttrRaw($v);
        }

        return $this;
    }

    public function appendAttrKv(string $key, string|int $value): static
    {
        $this->attrsLabes[$key]   = 1;
        $this->attrRegistry->$key = StandardAttr::class;
        $this->attrRegistry->$key->setKey($key)->setValue($value);

        return $this;
    }

    public function appendAttrKvArr(array $arr): static
    {
        foreach ($arr as $k => $v) {
            $this->appendAttrKv($k, $v);
        }

        return $this;
    }

    public function clearAttrs(): static
    {
        $this->attrsLabes = [];

        return $this;
    }

    /*
     * ------------------------------------------------------
     * ------------------------------------------------------
     */

    public function appendStyleKv(string $key, string|int $value): static
    {
        $this->getAttr('style')->setAttrKv($key, $value);

        return $this;
    }

    public function appendStyleKvArr(array $arr): static
    {
        $this->getAttr('style')->importKv($arr);

        return $this;
    }

    public function removeStyle(string $key): static
    {
        $this->getAttr('style')->removeKv($key);

        return $this;
    }

    public function getStyleKv(string $key): string
    {
        return $this->getAttr('style')->getAttrKv($key);
    }

    public function hasStyleKv(string $key): bool
    {
        return $this->getAttr('style')->hasAttrKv($key);
    }

    public function getAllStyleKv(): array
    {
        return $this->getAttr('style')->getAllAttrKv();
    }

    public function clearStyle(): static
    {
        $this->getAttr('style')->clearValue();

        return $this;
    }

    /*
     * ------------------------------------------------------
     * ------------------------------------------------------
     */
    public function evalAttrs(): string|int
    {
        return ' ' . $this->attrRegistry->evalAttrsByLabels(array_keys($this->attrsLabes));
    }

    public function evalClass(): string
    {
        return ' ' . $this->getAttr('class')->getValue();
    }

    public function evalStyle(): string
    {
        return ' ' . $this->getAttr('style')->getValue();
    }
}
