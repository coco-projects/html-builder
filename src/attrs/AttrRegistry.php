<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs;

    use Coco\htmlBuilder\traits\Statization;

class AttrRegistry
{
    use Statization;

    /**
     * @var ClassAttr|DataAttr|RawAttr|StandardAttr|StyleAttr[] $managerObjects
     */
    protected array $managerObjects = [];

    /**
     * @param string $label
     * @param string $managerName
     *
     * @return $this
     */
    public function initManager(string $label, string $managerName): static
    {
        if (!$this->hasManagerObjectByLabel($label)) {
            $this->managerObjects[$label] = new $managerName();
        }

        return $this;
    }

    /**
     * @param string $label
     *
     * @return ClassAttr|DataAttr|RawAttr|StandardAttr|StyleAttr|null
     */
    public function getManager(string $label): ClassAttr|DataAttr|RawAttr|StandardAttr|StyleAttr|null
    {
        return $this->managerObjects[$label] ?? null;
    }

    /**
     * @param string $label
     *
     * @return bool
     */
    public function hasManagerObjectByLabel(string $label): bool
    {
        return isset($this->managerObjects[$label]);
    }

    /**
     * @param string $label
     *
     * @return $this
     */
    public function removeManagerObjectByLabel(string $label): static
    {
        unset($this->managerObjects[$label]);
        return $this;
    }

    /**
     * @return array
     */
    public function getManagerObjects(): array
    {
        return $this->managerObjects;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        $results = [];

        foreach ($this->getManagerObjects() as $k => $attr) {
            $t = (string)$attr;
            if ($t) {
                $results[] = $t;
            }
        }

        return implode(' ', $results);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function __isset(mixed $offset): bool
    {
        return $this->hasManagerObjectByLabel($offset);
    }

    public function __get(mixed $offset): ClassAttr|DataAttr|RawAttr|StandardAttr|StyleAttr|null
    {
        return $this->getManager($offset);
    }

    public function __set(mixed $offset, mixed $value): void
    {
        $this->initManager($offset, $value);
    }

    public function __unset(mixed $offset): void
    {
        $this->removeManagerObjectByLabel($offset);
    }
}
