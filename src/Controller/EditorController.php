<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EditorController
 * @package App\Controller
 */
class EditorController extends AbstractController
{
    const PATH_INFO = '/editor';

    /**
     * @Route("/editor", name="editor_index", methods={"GET","HEAD"})
     *
     * @return Response
     */
    public function index(): Response
    {
        throw new NotFoundHttpException();
    }
}