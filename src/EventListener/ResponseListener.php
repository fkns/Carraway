<?php

namespace App\EventListener;

use App\Controller\EditorController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Class ResponseListener
 * @package App\EventListener
 */
class ResponseListener
{
    /**
     * @param ResponseEvent $event
     */
    public function onKernelResponse(ResponseEvent $event)
    {
        $this->handleCacheControlHeader($event);
    }

    /**
     * @param ResponseEvent $event
     */
    private function handleCacheControlHeader(ResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        if (strpos($request->getPathInfo(), EditorController::PATH_INFO) === false) {
            $event->setResponse($this->setCacheControlHeaderPublic($response));
        } else {
            $event->setResponse($this->setCacheControlHeaderPrivate($response));
        }
    }

    /**
     * @param Response $response
     * @return Response
     */
    private function setCacheControlHeaderPublic(Response $response)
    {
        $response->setPublic();

        return $response;
    }

    /**
     * @param Response $response
     * @return Response
     */
    private function setCacheControlHeaderPrivate(Response $response)
    {
        $response->setPrivate();

        return $response;
    }
}