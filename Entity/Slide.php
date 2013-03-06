<?php

namespace Isometriks\Bundle\SymEditBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Isometriks\Bundle\SymEditBundle\Entity\Slide
 *
 * @ORM\Table(name="slide")
 * @ORM\Entity
 */
class Slide
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $caption
     *
     * @ORM\Column(name="caption", type="string", length=255, nullable=true)
     */
    private $caption;
    
    
    /**
     * @var string $position
     * 
     * @ORM\Column(name="position", type="string", length=50, nullable=true)
     */
    private $position; 

    
    /**
     * @var Slider
     * 
     * @ORM\ManyToOne(targetEntity="Slider", inversedBy="slides")
     */
    private $slider; 
    
    /**
     * @var Image
     * 
     * @ORM\ManyToOne(targetEntity="Image", cascade={"persist"})
     */
    private $image; 

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set caption
     *
     * @param string $caption
     * @return Slide
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    
        return $this;
    }

    /**
     * Get caption
     *
     * @return string 
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set slider
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Slider $slider
     * @return Slide
     */
    public function setSlider(\Isometriks\Bundle\SymEditBundle\Entity\Slider $slider = null)
    {
        $this->slider = $slider;
    
        return $this;
    }

    /**
     * Get slider
     *
     * @return Isometriks\Bundle\SymEditBundle\Entity\Slider 
     */
    public function getSlider()
    {
        return $this->slider;
    }

    /**
     * Set image
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Image $image
     * @return Slide
     */
    public function setImage(\Isometriks\Bundle\SymEditBundle\Entity\Image $image = null)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return Isometriks\Bundle\SymEditBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set position
     *
     * @param string $position
     * @return Slide
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }
}