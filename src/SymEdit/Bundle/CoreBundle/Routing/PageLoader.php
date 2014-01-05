<?php

namespace SymEdit\Bundle\CoreBundle\Routing;

use Symfony\Component\Config\Loader\Loader as BaseLoader;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;

class PageLoader extends BaseLoader
{
    protected $pageRepository;

    public function __construct(RepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param type $resource
     * @param type $type
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public function load($resource = null, $type = null)
    {
        $pages = $this->pageRepository->findBy(array(
            'pageController' => false,
            'root' => false,
            'display' => true,
        ));

        $collection = new RouteCollection();

        /**
         * Add actual CMS Pages
         */
        foreach ($pages as $page) {
            $defaults = array(
                '_page_id' => $page->getId(),
                '_controller' => 'SymEditBundle:Page:show',
            );

            $collection->add($page->getRoute(), new Route($page->getPath(), $defaults));
        }

        return $collection;
    }

    public function supports($resource = null, $type = null)
    {
        return $type === 'symedit_pages';
    }
}