<?php

namespace App\Entity;

use App\Exception\DuplicatePermalinkException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CategoryCollection
 * @package App\Entity
 */
class CategoryCollection extends ArrayCollection
{
    /**
     * @var array
     */
    private $keys = [];

    /**
     * @param Category[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct($elements);
    }

    /**
     * @param $key
     * @return Category
     */
    public function get($key)
    {
        $category = parent::get($key);

        if (empty($category)) {
            throw new NotFoundHttpException();
        }

        return $category;
    }

    /**
     * @param string $key
     * @param Category $value
     */
    public function set($key, $value)
    {
        $this->validate($value);

        parent::set($key, $value);
    }

    /**
     * @param Category $element
     * @return bool
     */
    public function add($element)
    {
        $this->validate($element);

        parent::set($element->getName(), $element);

        return true;
    }

    /**
     * @param Category $element
     */
    private function validate(Category $element)
    {
        $name = $element->getName();

        if (array_key_exists($name, $this->keys)) {
            throw new DuplicatePermalinkException($name);
        }

        $this->keys[] = $name;
    }
}