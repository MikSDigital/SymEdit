<?php

namespace Isometriks\Bundle\SymEditBundle\Entity; 

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="images")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields={"path"}, message="There is already an image with this name, please choose another.")
 */
class Image extends File
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id; 

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }    
    
    protected function getUploadName()
    {
        return $this->name.'.'.$this->file->guessExtension(); 
    }
    
    protected function getUploadDir()
    {
        return 'img/uploads';
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            if(file_exists($file)){
                unlink($file);
            }
            
            $info = pathinfo( $file );
            $glob = sprintf( '%s/cache/%s_*', $info[ 'dirname' ], $info[ 'filename' ] );
            
            foreach( glob( $glob ) as $file ){
                unlink( $file );
            }
        }
    }


}