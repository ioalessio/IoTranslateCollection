<?php

namespace Io\TranslateCollectionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TranslateCollectionType extends CollectionType
{
    public $locales;
    
    function __construct($locales = array()) {
        $this->locales = $locales;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        parent::buildForm($builder, $options);
    }


    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'translate_collection';
    }
}