<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\StaticPageRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="public_index", methods={"GET","HEAD"})
     *
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->find(1);

        return $this->render('layout/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/page/{page}", name="public_page", methods={"GET","HEAD"}, requirements={"page"="\d+"})
     *
     * @param ArticleRepository $articleRepository
     * @param int $page
     * @return Response
     */
    public function page(ArticleRepository $articleRepository, int $page): Response
    {
        $articles = $articleRepository->find($page);

        return $this->render('layout/page.html.twig', ['articles' => $articles, 'page' => $page]);
    }

    /**
     * @Route("/category/{title}/{page}", name="public_category", methods={"GET","HEAD"}, requirements={"page"="\d+"})
     *
     * @param CategoryRepository $categoryRepository
     * @param string $title
     * @param int $page
     * @return Response
     */
    public function category(CategoryRepository $categoryRepository, string $title, int $page = 1): Response
    {
        $entity = $categoryRepository->findOne($title);
        $articles = $entity->getArticles()->page($page);

        return $this->render('layout/category.html.twig', ['category' => $entity, 'page' => $page, 'articles' => $articles]);
    }

    /**
     * @Route("/tag/{title}/{page}", name="public_tag", methods={"GET","HEAD"}, requirements={"page"="\d+"})
     *
     * @param TagRepository $tagRepository
     * @param string $title
     * @param int $page
     * @return Response
     */
    public function tag(TagRepository $tagRepository, string $title, int $page = 1): Response
    {
        $entity = $tagRepository->findOne($title);
        $articles = $entity->getArticles()->page($page);

        return $this->render('layout/tag.html.twig', ['tag' => $entity, 'page' => $page, 'articles' => $articles]);
    }

    /**
     * @Route("/article/{permalink}", name="public_article", methods={"GET","HEAD"})
     *
     * @param ArticleRepository $repository
     * @param string $permalink
     * @return Response
     * @throws \Exception
     */
    public function article(ArticleRepository $repository, string $permalink): Response
    {
        $article = $repository->findOneByPermalink($permalink);
        return $this->render($article->getLayout(), ['article' => $article]);
    }

    /**
     * @Route("/static/{pageName}", name="public_static", methods={"GET","HEAD"})
     *
     * @param StaticPageRepository $repository
     * @param string $pageName
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function staticPage(StaticPageRepository $repository, string $pageName): Response
    {
        $page = $repository->findOne($pageName);

        return new Response($page->render());
    }
}