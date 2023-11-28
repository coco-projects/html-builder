<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs;

    use Coco\htmlBuilder\traits\Statization;

class CustomAttrs
{
    use Statization;

    protected array $attrs  = [];
    protected array $class  = [];
    protected array $styles = [];

    /*
     * ------------------------------------------------------
     * ------------------------------------------------------
     */

    public function appendClass(string|int $class): static
    {
        $this->class[] = $class;

        return $this;
    }

    public function appendClassArr(array $classes): static
    {
        foreach ($classes as $k => $v) {
            $this->appendClass($v);
        }

        return $this;
    }

    /*
     * ------------------------------------------------------
     * ------------------------------------------------------
     */
    public function appendAttrRaw(string|int $attrString): static
    {
        $this->attrs[] = $attrString;

        return $this;
    }


    public function appendAttrRawArr(array $attrStrings): static
    {
        foreach ($attrStrings as $k => $v) {
            $this->appendAttrRaw($v);
        }

        return $this;
    }

    public function appendAttrKv(string|int $key, string|int $value): static
    {
        $this->attrs[] = $key . '="' . $value . '"';

        return $this;
    }


    public function appendAttrKvArr(array $arr): static
    {
        foreach ($arr as $k => $v) {
            $this->appendAttrKv($k, $v);
        }

        return $this;
    }

    /*
     * ------------------------------------------------------
     * ------------------------------------------------------
     */
    public function appendStyleRaw(string|int $attr): static
    {
        $this->styles[] = $attr;

        return $this;
    }

    public function appendStyleRawArr(array $attrs): static
    {
        foreach ($attrs as $k => $v) {
            $this->appendStyleRaw($v);
        }

        return $this;
    }


    public function appendStyleKv(string|int $key, string|int $value): static
    {
        $this->styles[] = "{$key}:{$value};";

        return $this;
    }

    public function appendStyleKvArr(array $arr): static
    {
        foreach ($arr as $k => $v) {
            $this->appendStyleKv($k, $v);
        }

        return $this;
    }

    /*
     * ------------------------------------------------------
     * ------------------------------------------------------
     */
    public function evalAttrs(): string|int
    {
        return implode(' ', $this->attrs);
    }

    public function evalClass(): string
    {
        return implode(' ', $this->class);
    }

    public function evalStyle(): string
    {
        return implode('', $this->styles);
    }
}
