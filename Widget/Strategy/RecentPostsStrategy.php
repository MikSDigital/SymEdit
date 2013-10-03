<?php

namespace Isometriks\Bundle\SymEditBundle\Widget\Strategy;

use Symfony\Component\Form\FormBuilderInterface;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Validator\Constraints\Range;
use Isometriks\Bundle\SymEditBundle\Model\PostManagerInterface;

class RecentPostsStrategy extends AbstractWidgetStrategy
{
    private $twig;
    private $postManager;

    public function __construct(\Twig_Environment $twig, PostManagerInterface $postManager)
    {
        $this->twig = $twig;
        $this->postManager = $postManager;
    }

    public function execute(WidgetInterface $widget)
    {
        $posts = $this->postManager->findRecentPosts($widget->getOption('max'));

        return $this->twig->render('@SymEdit/Widget/blog-recent-posts.html.twig', array(
            'posts' => $posts,
        ));
    }

    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('max', 'integer', array(
                'label' => 'Max Posts',
                'help_block' => 'Maximum Posts to display in Widget',
                'constraints' => array(
                    new Range(array(
                        'min' => 1,
                        'minMessage' => 'Minimum posts is 1, if you want less disable the widget.',
                    )),
                ),
            ));
    }

    public function setDefaultOptions(WidgetInterface $widget)
    {
        $widget->setOptions(array(
            'max' => 3,
        ));
    }

    public function getName()
    {
        return 'blog_recent_posts';
    }

    public function getDescription()
    {
        return 'Recent Posts';
    }
}