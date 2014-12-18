<?php

namespace Backend\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Backend\AdminBundle\Form\EventListener\PaisSubscriber;
use Backend\AdminBundle\Form\EventListener\ProvinciaSubscriber;

class SucursalType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('responsable')
            ->add('calle')
            ->add('numero')
            ->add('piso')
            ->add('cp')
            ->add('telefono')
            ->add('fax')
            ->add('email')
            
        ;
        
       $paisSubscriber = new PaisSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($paisSubscriber);
        
        $provinciaSubscriber = new ProvinciaSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($provinciaSubscriber);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Backend\AdminBundle\Entity\Sucursal'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backend_adminbundle_sucursal';
    }
}
