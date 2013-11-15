<?php

namespace Isometriks\Bundle\SymEditBundle\EventListener\Subscriber;

use Isometriks\Bundle\SeoBundle\Model\SeoInterface;
use Isometriks\Bundle\SymEditBundle\Event\Events;
use Isometriks\Bundle\SymEditBundle\Event\PostEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class PostSubscriber implements EventSubscriberInterface
{
    protected $session;
    protected $seo;

    public function __construct(Session $session, SeoInterface $seo)
    {
        $this->session = $session;
        $this->seo = $seo;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Events::POST_CREATED => 'postCreated',
            Events::POST_VIEW => 'postView',
        );
    }

    public function postCreated(PostEvent $event)
    {
        $this->session->getFlashBag()->add('notice', 'admin.post.flash.created');
    }

    public function postView(PostEvent $event)
    {
        $post = $event->getPost();
        $this->seo->setSubject($post);
    }
}