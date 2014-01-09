<?php

namespace SymEdit\Bundle\SeoBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use SymEdit\Bundle\SeoBundle\Model\SeoInterface;

/**
 * Event for SEO
 */
class SeoEvent extends Event
{
    protected $seo;
    protected $request;

    /**
     * Constructor
     *
     * @param SeoInterface $seo
     * @param Request $request
     */
    public function __construct(SeoInterface $seo, Request $request = null)
    {
        $this->seo = $seo;
        $this->request = $request;
    }

    /**
     * Get the request
     *
     * @return Request|null
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the current Seo instance
     *
     * @return SeoInterface
     */
    public function getSeo()
    {
        return $this->seo;
    }

    /**
     * Replace the current Seo instance
     *
     * @param SeoInterface $seo
     */
    public function setSeo(SeoInterface $seo)
    {
        $this->seo = $seo;
    }
}