<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\ArticleCollection;
use App\Storage\ArticleCollectionStorage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ArticleRepository
 * @package App\Repository
 */
class ArticleRepository
{
    /**
     * @var ArticleCollectionStorage
     */
    private $articleCollectionStorage;

    /**
     * @param ArticleCollectionStorage $articleCollectionStorage
     */
    public function __construct(ArticleCollectionStorage $articleCollectionStorage)
    {
        $this->articleCollectionStorage = $articleCollectionStorage;
    }

    /**
     * @param int $page
     * @param bool $activeOnly
     * @return ArticleCollection
     */
    public function find($page = 1, $activeOnly = true): ArticleCollection
    {
        $collection = $activeOnly ?
            $this->articleCollectionStorage->getActiveArticleCollection() :
            $this->articleCollectionStorage->getFullArticleCollection();

        return $collection->page($page);
    }

    /**
     * @param string $permalink
     * @param bool $activeOnly
     * @return Article
     */
    public function findOneByPermalink(string $permalink, $activeOnly = true): Article
    {
        $collection = $activeOnly ?
            $this->articleCollectionStorage->getActiveArticleCollection() :
            $this->articleCollectionStorage->getFullArticleCollection();

        foreach ($collection as $article) {
            /* @var Article $article */
            if ($article->getPermalink() == $permalink) {
                return $article;
            }
        }

        throw new NotFoundHttpException();
    }
}