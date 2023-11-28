<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs\abstractions;

    /**
     * 值是键值对的
     * style="margin-right: 10px;text-align: center;"
     */
abstract class KVAttributeAbstruct extends StandardAttributeAbstruct
{
    /**
     * @var array
     */
    protected array $AttrKv = [];

    /**
     * @param array $attrsArray
     */
    public function __construct(array $attrsArray = [])
    {
        parent::__construct('', '');
        $this->importKv($attrsArray);
    }

    /**
     * @param array $kv
     *
     * @return $this
     */
    public function importKv(array $kv): static
    {
        array_walk($kv, function (string|int $v, string $k) {
            $this->setAttrKv($k, $v);
        });

        return $this;
    }

    /**
     * @param string     $key
     * @param string|int $value
     *
     * @return $this
     */
    public function setAttrKv(string $key, string|int $value): static
    {
        $this->AttrKv[$key] = $value;
        $this->setValue($this->toValueString());

        return $this;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function removeKv(string $key): static
    {
        if (isset($this->AttrKv[$key])) {
            unset($this->AttrKv[$key]);
            $this->setValue($this->toValueString());
        }

        return $this;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getAttrKv(string $key): mixed
    {
        return (isset($this->AttrKv[$key])) ? ($this->AttrKv[$key]) : '';
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasAttrKv(string $key): bool
    {
        return isset($this->AttrKv[$key]);
    }

    /**
     * @return array
     */
    public function getAllAttrKv(): array
    {
        return $this->AttrKv;
    }

    public function clearValue(): static
    {
        $this->AttrKv = [];
        $this->setValue('');

        return $this;
    }

    /**
     * @return string
     */
    protected function buildKVString(): string
    {
        $t = [];
        foreach ($this->AttrKv as $key => $value) {
            $t[] = strtr($this->getTemplate(), [
                "__KEY__"   => $key,
                "__VALUE__" => $value,
            ]);
        }
        return implode('', $t);
    }

    /**
     * @return string
     */
    abstract protected function getTemplate(): string;


    /**
     * @return string
     */
    abstract protected function toValueString(): string;
}
