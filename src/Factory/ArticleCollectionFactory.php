<?php

namespace App\Factory;

use App\Entity\Article;
use App\Entity\ArticleCollection;
use App\Entity\Category;
use App\Entity\CategoryCollection;
use App\Entity\Tag;
use App\Entity\TagCollection;
use App\Service\MarkdownToHtmlConverter;
use Exception;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

/**
 * Class ArticleCollectionFactory
 * @package App\Factory
 */
class ArticleCollectionFactory
{
    /**
     * @var string
     */
    private $directoryPath;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var MarkdownToHtmlConverter
     */
    private $markdownToHtmlConverter;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var int
     */
    private $maxResult;

    /**
     * Markdown constructor.
     *
     * @param MarkdownToHtmlConverter $markdownToHtmlConverter
     * @param Environment $twig
     * @param string $directoryPath
     * @param int $maxResult
     */
    public function __construct(MarkdownToHtmlConverter $markdownToHtmlConverter, Environment $twig, string $directoryPath, int $maxResult = 3)
    {
        $this->markdownToHtmlConverter = $markdownToHtmlConverter;
        $this->twig = $twig;
        $this->directoryPath = $directoryPath;
        $this->maxResult = $maxResult;
        $this->finder = new Finder();
    }

    /**
     * @return ArticleCollection[] FullArticleCollection, ActiveArticleCollection, TagCollection, CategoryCollection
     * @throws \Exception
     */
    public function generate(): array
    {
        $finder = $this->finder->files();

        $finder->in($this->directoryPath);

        if ($finder->count() === 0) {
            throw new NotFoundHttpException();
        }

        $fullArticleCollection = new ArticleCollection([], $this->maxResult);
        $activeArticleCollection = new ArticleCollection([], $this->maxResult);
        $categoryCollection = new CategoryCollection();
        $tagCollection = new TagCollection();

        foreach ($finder as $fileInfo) {
            $article = $this->generateArticle($fileInfo, $categoryCollection, $tagCollection);

            // Full ArticleCollection
            $fullArticleCollection->add($article);

            if ($article->isActive()) {
                // Active ArticleCollection
                $activeArticleCollection->add($article);

                // Add an Article to a Category
                $article->getCategory()->getArticles()->add($article);

                // Add an Article to Tags
                foreach ($article->getTags() as $tag) {
                    /* @var Tag $tag */
                    $tag->getArticles()->add($article);
                }
            }
        }

        return [
            $fullArticleCollection,
            $activeArticleCollection,
            $categoryCollection,
            $tagCollection
        ];
    }

    /**
     * @param SplFileInfo $fileInfo
     * @param CategoryCollection $categoryCollection
     * @param TagCollection $tagCollection
     * @return Article
     * @throws Exception
     */
    private function generateArticle(SplFileInfo $fileInfo, CategoryCollection $categoryCollection, TagCollection $tagCollection): Article
    {
        $object = YamlFrontMatter::parse($fileInfo->getContents());
        $body = $object->body();
        $title = $object->matter('title');
        $category = $this->getCategory($categoryCollection, $object->matter('category'));
        $tagCollection = $this->getTagCollection($tagCollection, $object->matter('tag'));

        return new Article(
            $object->matter('layout'),
            $fileInfo->getFilename(),
            $title,
            $object->matter('permalink'),
            new \DateTime($object->matter('date')),
            $category,
            $tagCollection,
            $body,
            $this->markdownToHtmlConverter->convert($body),
            is_bool($object->matter('published')) ? $object->matter('published') : true
        );
    }

    /**
     * @param CategoryCollection $categoryCollection
     * @param string $categoryName
     * @return Category
     */
    private function getCategory(CategoryCollection $categoryCollection, string $categoryName): Category
    {
        if ($categoryCollection->containsKey($categoryName)) {
            return $categoryCollection->get($categoryName);
        }

        $newCategory = new Category($categoryName, new ArticleCollection([], $this->maxResult));

        $categoryCollection->add($newCategory);

        return $newCategory;
    }

    /**
     * @param TagCollection $fullTagCollection
     * @param array $tagStringArray
     * @return TagCollection
     */
    private function getTagCollection(TagCollection $fullTagCollection, array $tagStringArray): TagCollection
    {
        $tagCollection = new TagCollection();

        foreach ($tagStringArray as $tagName) {
            if ($fullTagCollection->containsKey($tagName)) {
                $tag = $fullTagCollection->get($tagName);
            } else {
                $tag = new Tag($tagName, new ArticleCollection([], $this->maxResult));
                $fullTagCollection->add($tag);
            }

            $tagCollection->add($tag);
        }

        return $tagCollection;
    }
}