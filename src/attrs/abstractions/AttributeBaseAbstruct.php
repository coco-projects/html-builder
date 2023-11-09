<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs\abstractions;

    use Coco\htmlBuilder\traits\Statization;

    /**
     * 属性基础方法
     * 整个属性字符串
     */
abstract class AttributeBaseAbstruct
{
    use Statization;

    protected string|int $attrsString = '';
    protected bool       $isEnable    = true;

    /**
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->isEnable;
    }

    /**
     * @param bool $isEnable
     *
     * @return $this
     */
    public function setIsEnable(bool $isEnable): static
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    /**
     * @return string
     */
    public function getAttrsString(): string
    {
        return $this->toString();
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->isEnable() ? $this->toString() : '';
    }

    /**
     * @return string
     */
    abstract protected function toString(): string;
}
