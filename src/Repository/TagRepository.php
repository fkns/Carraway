<?php

namespace App\Repository;

use App\Entity\Tag;
use App\Storage\ArticleCollectionStorage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TagRepository
 * @package App\Repository
 */
class TagRepository
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
     * @return Tag
     */
    public function findOne(string $name): Tag
    {
        $collection = $this->articleCollectionStorage->getTagCollection();

        if (!$collection->containsKey($name)) {
            throw new NotFoundHttpException();
        }

        return $collection->get($name);
    }
}