<?php

namespace App\Entity;

use App\Exception\DuplicatePermalinkException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ArticleCollection
 * @package App\Entity
 */
class ArticleCollection extends ArrayCollection
{
    /**
     * @var array
     */
    private $keys = [];

    /**
     * @var int
     */
    private $maxResult;

    /**
     * @var int|null
     */
    private $currentPage = null;

    /**
     * @var int|null
     */
    private $pageNum = null;

    /**
     * @param Article[] $elements
     * @param int $maxResult
     */
    public function __construct(array $elements = [], int $maxResult = 5)
    {
        $this->maxResult = $maxResult;

        parent::__construct($elements);
    }

    /**
     * @param string $key
     * @param Article $value
     */
    public function set($key, $value)
    {
        $this->validate($value);

        parent::set($key, $value);
    }

    /**
     * @param Article $element
     * @return bool
     */
    public function add($element)
    {
        $this->validate($element);

        parent::set($element->getPermalink(), $element);

        return true;
    }

    /**
     * @param $key
     * @return Article
     */
    public function get($key): Article
    {
        $article = parent::get($key);

        if (empty($article)) {
            throw new NotFoundHttpException();
        }

        return $article;
    }

    /**
     * @param int $page
     * @return ArticleCollection
     */
    public function page(int $page = 1)
    {
        $offset = $this->maxResult * ($page - 1);
        $pageNum = ceil($this->count() / $this->maxResult);

        $criteria = new Criteria(null, ['date' => Criteria::DESC], $offset, $this->maxResult);

        $result = $this->matching($criteria);
        $result->setCurrentPage($page);
        $result->setPageNum($pageNum);

        return $result;
    }

    /**
     * @return bool
     */
    public function isFirstPage(): bool
    {
        return $this->currentPage === 1;
    }

    /**
     * @return bool
     */
    public function isLastPage(): bool
    {
        return $this->currentPage === $this->pageNum;
    }

    /**
     * @return int
     */
    public function lastPage(): int
    {
        return $this->pageNum;
    }

    /**
     * @param array $elements
     * @return $this|ArrayCollection
     */
    protected function createFrom(array $elements)
    {
        return new static($elements, $this->maxResult);
    }

    /**
     * @param int|null $currentPage
     */
    private function setCurrentPage(?int $currentPage): void
    {
        $this->currentPage = $currentPage;
    }

    /**
     * @param int|null $pageNum
     */
    private function setPageNum(?int $pageNum): void
    {
        $this->pageNum = $pageNum;
    }

    /**
     * @param Article $article
     */
    private function validate(Article $article)
    {
        $permalink = $article->getPermalink();

        if (array_key_exists($permalink, $this->keys)) {
            throw new DuplicatePermalinkException($permalink);
        }

        $this->keys[] = $permalink;
    }
}