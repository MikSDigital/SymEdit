<?php

namespace SymEdit\Bundle\CoreBundle\Event;

use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class PageEvent extends Event
{
    private $request;
    private $page;

    public function __construct(PageInterface $page, Request $request)
    {
        $this->page = $page;
        $this->request = $request;
    }

    /**
     * @return PageInterface
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}