<?php

namespace App\Entity;

use App\Exception\DuplicatePermalinkException;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TagCollection
 * @package App\Entity
 */
class TagCollection extends ArrayCollection
{
    /**
     * @var array
     */
    private $keys = [];

    /**
     * @param Tag[] $elements
     */
    public function __construct(array $elements = [])
    {
        parent::__construct($elements);
    }

    /**
     * @param $key
     * @return Tag
     */
    public function get($key): Tag
    {
        $tag = parent::get($key);

        if (empty($tag)) {
            throw new NotFoundHttpException();
        }

        return $tag;
    }

    /**
     * @param string $key
     * @param Tag $value
     */
    public function set($key, $value)
    {
        $this->validate($value);

        parent::set($key, $value);
    }

    /**
     * @param Tag $element
     * @return bool
     */
    public function add($element)
    {
        $this->validate($element);

        parent::set($element->getName(), $element);

        return true;
    }

    /**
     * @param Tag $element
     */
    private function validate(Tag $element)
    {
        $name = $element->getName();

        if (array_key_exists($name, $this->keys)) {
            throw new DuplicatePermalinkException($name);
        }

        $this->keys[] = $name;
    }
}