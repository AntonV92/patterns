<?php

include_once "Composite.php";

/**
 * Class Component
 */
abstract class Component
{
    /**
     * @var float|null
     */
    protected ?float $price;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var SplObjectStorage
     */
    protected SplObjectStorage $components;

    /**
     * Component constructor.
     */
    public function __construct()
    {
        $this->components = new SplObjectStorage();
    }

    /**
     * @var Component|null
     */
    protected ?Component $parent = null;

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param Component $component
     * @throws Exception
     */
    public function add(Component $component)
    {
        if (!$this->isComposite()) {
            throw new Exception('Can not add to leaf object');
        }
        $component->setParent($this);
        $this->components->attach($component);
    }

    /**
     * @param Component $component
     * @throws Exception
     */
    public function remove(Component $component)
    {
        if (!$this->isComposite()) {
            throw new Exception('Can not remove from leaf object');
        }
        $component->removeParent();
        $this->components->detach($component);
    }

    /**
     * @return float|null
     */
    public function getPrice():? float
    {
        if ($this->isComposite()) {
            $total = 0;
            foreach ($this->components as $component) {
                $total += $component->getPrice();
            }

            return $this->price + $total;
        }

        return $this->price;
    }

    /**
     * @return Component|null
     */
    public function getParent():? Component
    {
        return $this->parent;
    }

    /**
     * @return bool
     */
    protected function isComposite(): bool
    {
        return $this instanceof Composite;
    }

    /**
     * @param Component $parent
     */
    protected function setParent(Component $parent)
    {
        $this->parent = $parent;
    }

    protected function removeParent(): void
    {
        $this->parent = null;
    }

}