<?php

namespace App\Entity;

/**
 * Class Article
 * @package App\Entity
 */
class Article
{
    /**
     *
     */
    const LAYOUT = 'layout/%s.html.twig';

    /**
     * @var string
     */
    private $layout;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $permalink;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var TagCollection
     */
    private $tags;

    /**
     * @var bool
     */
    private $published;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $html;

    /**
     * Article constructor.
     * @param string $layout
     * @param string $fileName
     * @param string $title
     * @param string $permalink
     * @param \DateTime $date
     * @param Category $category
     * @param TagCollection $tags
     * @param bool $published
     * @param string $body
     * @param string $html
     */
    public function __construct(string $layout, string $fileName, string $title, string $permalink, \DateTime $date, Category $category, TagCollection $tags, string $body, string $html, bool $published = true)
    {
        $this->layout = $layout;
        $this->fileName = $fileName;
        $this->title = $title;
        $this->permalink = $permalink;
        $this->date = $date;
        $this->category = $category;
        $this->tags = $tags;
        $this->published = $published;
        $this->body = $body;
        $this->html = $html;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isActive(): bool
    {
        return $this->isPublished() && $this->getDate()->getTimestamp() < (new \DateTime())->getTimestamp();
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return sprintf(Article::LAYOUT, $this->layout);
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getPermalink(): string
    {
        return $this->permalink;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @return TagCollection
     */
    public function getTags(): TagCollection
    {
        return $this->tags;
    }

    /**
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->published;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->html;
    }
}