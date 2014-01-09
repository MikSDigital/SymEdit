<?php

namespace SymEdit\Bundle\SeoBundle\Model;

use SymEdit\Bundle\SeoBundle\Event\Events;
use SymEdit\Bundle\SeoBundle\Event\SeoEvent;
use SymEdit\Bundle\SeoBundle\Model\SeoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @TODO Do we really need getCalculatedSeo here? Or do we need to store
 * this reference to the main seo? This class could be better used to 
 * create / save seo things with the SEO model..
 */
class SeoManager implements SeoManagerInterface
{
    protected $dispatcher;
    protected $class;
    protected $seo;
    
    public function __construct(SeoInterface $seo, EventDispatcherInterface $dispatcher)
    {
        $this->seo = $seo;
        $this->dispatcher = $dispatcher;
    }
    
    public function getSeo()
    {
        return $this->seo;
    }
    
    public function setSeo(SeoInterface $seo)
    {
        $this->seo = $seo;
    }
    
    public function addCalculator(SeoCalculatorInterface $calculator, $priority = 0)
    {
        $this->dispatcher->addListener(Events::CALCULATE_SEO, array($calculator, 'calculateSeo'), $priority);
    }
    
    public function getCalculatedSeo(Request $request = null)
    {
        $event = new SeoEvent($this->seo, $request);
        $this->dispatcher->dispatch(Events::CALCULATE_SEO, $event);
        
        return $this->getSeo();
    }
}