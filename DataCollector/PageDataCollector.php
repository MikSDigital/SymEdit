<?php

namespace Isometriks\Bundle\SymEditBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageDataCollector extends DataCollector
{
    public function __construct()
    {
        $this->data = null;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {

        if ($request->attributes->has('_page')) {

            $page = $request->attributes->get('_page');
            $chunks = array();

            foreach ($page->getChunks() as $chunk) {
                $chunks[] = array(
                    'name' => $chunk->getName(),
                    'options' => $chunk->getOptions(),
                    'strategy' => $chunk->getStrategyName(),
                );
            }

            $this->data = array(
                'id' => $page->getId(),
                'path' => $page->getPath(),
                'title' => $page->getTitle(),
                'template' => $page->getTemplate(),
                '_controller' => $request->attributes->get('_controller'),
                'controller' => $page->getPageController(),
                'controllerPath' => $page->getPageControllerPath(),
                'chunks' => $chunks,
            );
        }
    }

    public function getPage()
    {
        return $this->data;
    }

    public function getChunks()
    {
        return $this->data['chunks'];
    }

    public function getName()
    {
        return 'symedit_page';
    }
}