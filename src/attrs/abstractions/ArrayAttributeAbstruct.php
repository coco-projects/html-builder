<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs\abstractions;

    /**
     * 值是数组的
     * class="layui-layout layui-layout-admin"
     */
abstract class ArrayAttributeAbstruct extends StandardAttributeAbstruct
{
    /**
     * @var string[]
     */
    private array $attrsArray = [];

    public function __construct(array $attrsArray = [])
    {
        parent::__construct('', '');
        $this->setAttrsArray($attrsArray);
    }

    /**
     * @param array $attrsArray
     *
     * @return $this
     */
    public function setAttrsArray(array $attrsArray): static
    {
        $this->attrsArray = array_flip($attrsArray);
        $this->setValue($this->toValueString());

        return $this;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function addAttr(string $value): static
    {
        $this->attrsArray[$value] = '';
        $this->setValue($this->toValueString());

        return $this;
    }

    /**
     * @return array
     */
    public function getAttrs(): array
    {
        return array_keys($this->attrsArray);
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function removeAttr(string $value): static
    {
        if (isset($this->attrsArray[$value])) {
            unset($this->attrsArray[$value]);
            $this->setValue($this->toValueString());
        }

        return $this;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function hasAttr(string $value): bool
    {
        return isset($this->attrsArray[$value]);
    }

    /**
     * @return string
     */
    abstract protected function toValueString(): string;
}
