<?php


namespace Io\TranslateCollectionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\Extension\Core\Type;

class TranslateCollectionType extends CollectionType
{
    public $locales;
    
    function __construct($locales = array() ) 
    {
        $this->locales = $locales;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['allow_add'] && $options['prototype']) {
            $prototype = $builder->create($options['prototype_name'], $options['type'], array_replace(array(
                'label' => $options['prototype_name'] . 'label__',
            ), $options['options']));
            $builder->setAttribute('prototype', $prototype->getForm());
        }

        $resizeListener = new ResizeFormListener(
            $options['type'],
            $options['options'],
            $options['allow_add'],
            $options['allow_delete']
        );

        $builder->addEventSubscriber($resizeListener);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'allow_add'    => $options['allow_add'],
            'allow_delete' => $options['allow_delete'],
        ));

        if ($form->getConfig()->hasAttribute('prototype')) {
            $view->vars['prototype'] = $form->getConfig()->getAttribute('prototype')->createView($view);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        if ($form->getConfig()->hasAttribute('prototype') && $view->vars['prototype']->vars['multipart']) {
            $view->vars['multipart'] = true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $optionsNormalizer = function (Options $options, $value) {
            $value['block_name'] = 'entry';

            return $value;
        };

        $resolver->setDefaults(array(
            'allow_add'      => false,
            'allow_delete'   => false,
            'prototype'      => true,
            'prototype_name' => '__name__',
            'type'           => 'text',
            'options'        => array(),
        ));

        $resolver->setNormalizers(array(
            'options' => $optionsNormalizer,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'translate_collection';
    }
}