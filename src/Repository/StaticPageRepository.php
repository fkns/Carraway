<?php

namespace App\Repository;

use App\Entity\StaticPage;
use Twig\Environment;

/**
 * Class StaticPageRepository
 * @package App\Repository
 */
class StaticPageRepository
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $pageName
     * @return StaticPage
     */
    public function findOne(string $pageName): StaticPage
    {
        return $this->generateEntity($pageName);
    }

    /**
     * @param string $pageName
     * @return StaticPage
     */
    private function generateEntity(string $pageName): StaticPage
    {
        return new StaticPage($pageName, $this->twig);
    }
}