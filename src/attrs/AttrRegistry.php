<?php

    declare(strict_types = 1);

    namespace Coco\htmlBuilder\attrs;

    use Coco\htmlBuilder\traits\Statization;

class AttrRegistry
{
    use Statization;

    /**
     * @var ClassAttr|DataAttr|RawAttr|StandardAttr|StyleAttr[] $managers
     */
    protected array $managers = [];

    private $beforeGetValueCallback = null;

    /**
     * @param string $label
     * @param string $managerName
     *
     * @return $this
     */
    public function initManager(string $label, string $managerName): static
    {
        if (!$this->hasManagerByLabel($label)) {
            $this->managers[$label] = new $managerName();
        }

        return $this;
    }

    /**
     * @param string $label
     *
     * @return ClassAttr|DataAttr|RawAttr|StandardAttr|StyleAttr|null
     */
    public function getManagerByLabel(string $label): ClassAttr|DataAttr|RawAttr|StandardAttr|StyleAttr|null
    {
        return $this->managers[$label] ?? null;
    }

    /**
     * @param string $label
     *
     * @return bool
     */
    public function hasManagerByLabel(string $label): bool
    {
        return isset($this->managers[$label]);
    }

    public function removeManagerByLabel(string $label): static
    {
        unset($this->managers[$label]);

        return $this;
    }

    public function getManagers(): array
    {
        return $this->managers;
    }

    public function evalAttrsToString(): string
    {
        $results = [];

        foreach ($this->getManagers() as $k => $attr) {
            $t = (string)$attr;
            if ($t) {
                $results[] = $t;
            }
        }

        $resultString = implode(' ', $results);

        if (is_callable($this->beforeGetValueCallback)) {
            call_user_func_array($this->beforeGetValueCallback, [&$resultString]);
        }

        return $resultString;
    }

    /**
     * @param array $labels
     *
     * @return string
     */
    public function evalAttrsByLabels(array $labels): string
    {
        $results = [];

        foreach ($labels as $k => $label) {
            $manager = $this->getManagerByLabel($label);
            if ($manager) {
                $t = (string)$manager;
                if ($t) {
                    $results[] = $t;
                }
            }
        }

        $resultString = implode(' ', $results);

        return $resultString;
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

    public function __toString(): string
    {
        return (string)$this->evalAttrsToString();
    }

    public function __isset(mixed $offset): bool
    {
        return $this->hasManagerByLabel($offset);
    }

    public function __get(mixed $offset): ClassAttr|DataAttr|RawAttr|StandardAttr|StyleAttr|null
    {
        return $this->getManagerByLabel($offset);
    }

    public function __set(mixed $offset, mixed $value): void
    {
        $this->initManager($offset, $value);
    }

    public function __unset(mixed $offset): void
    {
        $this->removeManagerByLabel($offset);
    }
}
