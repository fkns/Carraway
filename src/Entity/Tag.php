<?php

namespace App\Entity;

/**
 * Class Tag
 * @package App\Entity
 */
class Tag
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ArticleCollection
     */
    private $articles;

    /**
     * Tag constructor.
     * @param string $name
     * @param ArticleCollection|null $articles
     */
    public function __construct(string $name, ?ArticleCollection $articles = null)
    {
        $this->name = $name;
        $this->articles = $articles ?? new ArticleCollection();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return ArticleCollection
     */
    public function getArticles(): ArticleCollection
    {
        return $this->articles;
    }
}