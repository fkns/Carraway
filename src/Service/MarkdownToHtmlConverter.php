<?php

namespace App\Service;

use Parsedown;

/**
 * Class HtmlConverter
 * @package App\Markdown
 */
class MarkdownToHtmlConverter
{
    /**
     * @var Parsedown
     */
    private $parsedown;

    /**
     * HtmlConverter constructor.
     */
    public function __construct()
    {
        $this->parsedown = new Parsedown();
    }

    /**
     * @param string $markdown
     * @return string
     */
    public function convert(string $markdown): string
    {
        return $this->parsedown->text($markdown);
    }
}