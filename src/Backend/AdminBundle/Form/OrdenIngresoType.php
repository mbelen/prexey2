<?php

namespace Backend\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class OrdenIngresoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('observaciones')
            ->add('documento')
			->add('tipo','entity',array(
                'class'=>'BackendAdminBundle:TipoOrdenIngreso',
                'property'=>'name',
            ))		
            ->add('cliente','entity',array(
                'class'=>'BackendAdminBundle:Cliente',
                'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                        ->where('u.isDelete = :delete')                        
                        ->setParameter('delete',false)
                        ->orderBy('u.name', 'ASC');                         
            },
                'property'=>'name',
                'multiple'=>false //un solo deposito por operario
            ))
            ->add('operador','entity',array(
                'class'=>'BackendAdminBundle:OperadorLogistico',
                'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                        ->where('u.isDelete = :delete')                        
                        ->setParameter('delete',false)
                        ->orderBy('u.name', 'ASC');                         
            },
                'property'=>'name',
                'multiple'=>false //un solo deposito por operario
            ))                        
			
			->add('ingresos', 'collection', array('type' => new IngresoType(),
				  'allow_add'    => true,
				  'by_reference' => false,
			));
       }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Backend\AdminBundle\Entity\OrdenIngreso'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backend_adminbundle_ordenIngreso';
    }
}
