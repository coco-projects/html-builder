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
     * @return StandardAttributeAbstruct
     */
    public function setKey(string $key): StandardAttributeAbstruct
    {
        ($key && parent::setKey('data-' . $key));
        return $this;
    }

    /**
     * @param string     $key
     * @param string|int $value
     *
     * @return StandardAttributeAbstruct
     */
    public function setDataKv(string $key = '', string|int $value = ''): StandardAttributeAbstruct
    {
        ($key && parent::setKey('data-' . $key));
        $this->setValue($value);
        return $this;
    }
}
