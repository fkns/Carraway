<?php

namespace App\Storage;

use App\Entity\ArticleCollection;
use App\Entity\CategoryCollection;
use App\Entity\TagCollection;
use App\Factory\ArticleCollectionFactory;

/**
 * Class ArticleCollectionStorage
 * @package App\Storage
 */
class ArticleCollectionStorage
{
    /**
     * @var TagCollection
     */
    private $tagCollection;

    /**
     * @var CategoryCollection
     */
    private $categoryCollection;

    /**
     * @var ArticleCollection
     */
    private $fullArticleCollection;

    /**
     * @var ArticleCollection
     */
    private $activeArticleCollection;

    /**
     * ArticleCollectionStorage constructor.
     * @param ArticleCollectionFactory $articleCollectionFactory
     * @throws \Exception
     */
    public function __construct(ArticleCollectionFactory $articleCollectionFactory)
    {
        [$this->fullArticleCollection, $this->activeArticleCollection, $this->categoryCollection, $this->tagCollection] = $articleCollectionFactory->generate();
    }

    /**
     * @return TagCollection
     */
    public function getTagCollection(): TagCollection
    {
        return $this->tagCollection;
    }

    /**
     * @return CategoryCollection
     */
    public function getCategoryCollection(): CategoryCollection
    {
        return $this->categoryCollection;
    }

    /**
     * @return ArticleCollection
     */
    public function getFullArticleCollection(): ArticleCollection
    {
        return $this->fullArticleCollection;
    }

    /**
     * @return ArticleCollection
     */
    public function getActiveArticleCollection(): ArticleCollection
    {
        return $this->activeArticleCollection;
    }
}