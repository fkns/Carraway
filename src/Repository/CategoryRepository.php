<?php

namespace App\Repository;

use App\Entity\Category;
use App\Storage\ArticleCollectionStorage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CategoryRepository
 * @package App\Repository
 */
class CategoryRepository
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
     * @param string $name
     * @return Category
     */
    public function findOne(string $name): Category
    {
        $collection = $this->articleCollectionStorage->getCategoryCollection();

        if (!$collection->containsKey($name)) {
            throw new NotFoundHttpException();
        }

        return $collection->get($name);
    }
}