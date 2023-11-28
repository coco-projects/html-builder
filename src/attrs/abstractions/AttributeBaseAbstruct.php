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

    protected string|int $attrsString            = '';
    private bool         $isEnable               = true;
    private $beforeGetValueCallback = null;

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
     * @return string|int
     */
    public function getAttrsString(): string|int
    {
        $str = $this->evalAttrs();

        if (is_callable($this->beforeGetValueCallback)) {
            call_user_func_array($this->beforeGetValueCallback, [&$str]);
        }

        return $str;
    }

    /**
     * @param callable $beforeGetValueCallback
     *
     * @return $this
     */
    public function setBeforeGetValueCallback(callable $beforeGetValueCallback): static
    {
        $this->beforeGetValueCallback = $beforeGetValueCallback;

        return $this;
    }

    /**
     * @param string|int $attrsString
     *
     * @return $this
     */
    public function setAttrsString(string|int $attrsString): static
    {
        $this->attrsString = $attrsString;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->isEnable() ? $this->getAttrsString() : '';
    }

    /**
     * @return string|int
     */
    abstract protected function evalAttrs(): string|int;
}
