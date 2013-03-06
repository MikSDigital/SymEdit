<?php

namespace Isometriks\Bundle\SymEditBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface; 
use Symfony\Component\DependencyInjection\ContainerAwareInterface; 
use Isometriks\Bundle\SymEditBundle\Twig\TokenParser; 
use Isometriks\Bundle\SymEditBundle\Entity\Image; 

class SymEditExtension extends \Twig_Extension implements ContainerAwareInterface
{
    private $hostBundle;
    private $extensions;
    
    /**
     * @var ContainerInterface
     */
    private $container; 

    public function __construct(ContainerInterface $container, $hostBundle, array $extensions = array())
    {
        $this->setContainer($container); 
        $this->hostBundle = $hostBundle;
        $this->extensions = $extensions; 
    }

    public function getGlobals()
    {
        $em = $this->container->get('doctrine')->getManager();
        $pages = $em->getRepository('IsometriksSymEditBundle:Page'); 
        
        $len = strlen($this->hostBundle); 
        $asset_dir = $this->hostBundle; 
        
        if(strtolower(substr($this->hostBundle, -6)) === 'bundle'){
            $asset_dir = substr($this->hostBundle, 0, $len-6);
        }
        
        $globals = array(
            'Root' => $pages->findRoot(),
            'Tree' => $pages, 
            'Blog' => $em->getRepository('IsometriksSymEditBundle:Post'),
            'Categories' => $em->getRepository('IsometriksSymEditBundle:Category'),
            'host_bundle' => $this->hostBundle,
            'host_asset_dir' => strtolower($asset_dir), 
        );
        
        $context = $this->container->get('security.context'); 
        
        if($context->getToken() !== null && $context->isGranted('ROLE_ADMIN')){
            $globals['extensions'] = $this->getExtensions(); 
        }
        
        // Inject the Page variable globally in case
        // you skipped it in the controller, or didn't need it. 
        if($this->container->has('request')){
            $request = $this->container->get('request'); 
            
            if($request->attributes->has('_page')){
                $page = $request->attributes->get('_page'); 
                $globals['Page'] = $page; 
                $globals['SEO']  = $page->getSeo(); 
            }
        }
        
        return $globals; 
    }

    public function getFilters()
    {
        return array(
            'constrain' => new \Twig_Filter_Method($this, 'imageConstrain'),
            'plain'     => new \Twig_Filter_Method($this, 'plain'),
        );
    }

    public function imageConstrain($src, $args)
    {
        // If you try to constrain an Image object directly
        if($src instanceof Image){
            $src = $src->getWebPath(); 
        }
        
        return $this->container->get('isometriks_sym_edit.util.image_manipulator')->constrain($src, $args);
    }
    
    private function getExtensions()
    {
        $extensions = array(); 
        foreach($this->extensions as $extension){
            if($this->container->get('security.context')->isGranted($extension['role'])){
                $extensions[] = $extension; 
            }
        }
        
        return $extensions; 
    }

    /**
     * This is used for things like generating meta descriptions from page content. We need
     * it to be plain text with no breaks. There is a limit which will truncate the text so
     * meta tags won't be filled with too much text. 
     * 
     * @param string $text
     * @param int $limit
     * @return string
     */
    public function plain($text, $limit = null, $ellipsis = null)
    {
        $text = strip_tags($text);
        $text = htmlentities($text);
        $text = str_replace(array("\n", "\r"), ' ', $text);
        $len  = strlen($text);
        
        if (isset($limit) && is_int($limit) && $len > $limit) {
            $text = substr($text, 0, $limit);
            
            if($ellipsis !== null){
                $text .= $ellipsis; 
            }
        }

        return $text;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container; 
    }
    
    public function getName()
    {
        return 'SymEditBundleExtension';
    }
}