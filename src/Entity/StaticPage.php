<?php

namespace App\Entity;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class StaticPage
 * @package App\Entity
 */
class StaticPage
{
    const FORMAT = 'static/%s.html.twig';

    private $pageName;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * Markdown constructor.
     * @param string $pageName
     * @param Environment $twig
     */
    public function __construct(string $pageName, Environment $twig)
    {
        $this->pageName = $pageName;
        $this->twig = $twig;
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(): string
    {
        $fileName = sprintf(self::FORMAT, $this->pageName);

        return $this->twig->render($fileName);
    }
}