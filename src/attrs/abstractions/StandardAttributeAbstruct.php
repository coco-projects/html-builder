<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs\abstractions;

    /**
     * 键值对形式属性
     * style="margin-right: 10px;text-align: center;"
     * data-title="用户中心"
     */
abstract class StandardAttributeAbstruct extends AttributeBaseAbstruct
{
    private string $key   = '';
    private mixed  $value = '';

    public function __construct(string $key = '', string|int $value = '')
    {
        $this->setKey($key);
        $this->setValue($value);
    }

    /**
     * @param string     $key
     * @param string|int $value
     *
     * @return $this
     */
    public function setAttrKv(string $key, string|int $value): static
    {
        $this->setKey($key);
        $this->setValue($value);

        return $this;
    }

    /**
     * 属性的键
     *
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    /**
     * 属性的值
     *
     * @param string|int $value
     *
     * @return $this
     */
    public function setValue(string|int $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string|int
     */
    public function getValue(): string|int
    {
        return $this->value;
    }

    /**
     * @return $this
     */
    public function clearValue(): static
    {
        $this->value = '';

        return $this;
    }

    /**
     * @return string|int
     */
    protected function evalAttrs(): string|int
    {
        if ($this->getKey()) {
            return $this->getKey() . '="' . strtr((string)$this->getValue(), ['"' => '\"',]) . '"';
        }

        return '';
    }
}
