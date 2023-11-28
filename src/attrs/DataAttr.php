<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs;

    use Coco\htmlBuilder\attrs\abstractions\StandardAttributeAbstruct;

class DataAttr extends StandardAttributeAbstruct
{
    public function __construct(string $key = '', string|int $value = '')
    {
        parent::__construct($key, $value);
        $this->setValue($value);
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key): static
    {
        ($key && parent::setKey('data-' . $key));

        return $this;
    }

    /**
     * @param string     $key
     * @param string|int $value
     *
     * @return $this
     */
    public function setDataKv(string $key = '', string|int $value = ''): static
    {
        ($key && parent::setKey('data-' . $key));
        $this->setValue($value);

        return $this;
    }
}
