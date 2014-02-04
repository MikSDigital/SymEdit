<?php

namespace SymEdit\Bundle\MediaBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use SymEdit\Bundle\MediaBundle\Form\DataTransformer\GalleryChooseDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageChooseType extends AbstractType
{
    protected $imageRepository;
    protected $itemRepository;

    public function __construct(RepositoryInterface $imageRepository, RepositoryInterface $itemRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->itemRepository = $itemRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer(new GalleryChooseDataTransformer($this->imageRepository, $this->itemRepository));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $choices = array();
        $labels = array();

        foreach ($this->imageRepository->findAll() as $image) {
            $choices[] = $image;
            $labels[] = $image->getName();
        }

        $resolver->setDefaults(array(
            'expanded' => true,
            'multiple' => true,
            'choice_list' => new \Symfony\Component\Form\Extension\Core\ChoiceList\ObjectChoiceList($choices, 'name'),
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'symedit_image_choose';
    }
}