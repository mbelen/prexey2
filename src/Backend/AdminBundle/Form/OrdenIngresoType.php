<?php

namespace Backend\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Backend\AdminBundle\Entity\Ingreso;

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
            /*
             ->add('area','entity',array(
                'class'=>'BackendAdminBundle:AreaTrabajo',
                'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                        ->where('u.isDelete = :delete')
                        ->andWhere('u.id != 2')                        
                        ->setParameter('delete',false)
                        ->orderBy('u.nombre', 'ASC');                         
            },
                'property'=>'nombre',
                'multiple'=>false //un solo deposito por operario
            )) */
             ->add('deposito','entity',array(
                'class'=>'BackendAdminBundle:Deposito',
                'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                        //->where('u.isDelete = :delete')
                        //->andWhere('u.id != 2')                        
                        //->setParameter('delete',false)
                        ->orderBy('u.nombre', 'ASC');                         
            },
                'property'=>'nombre',
                'multiple'=>false //un solo deposito por operario
            ))                            
			/*
			->add('ingresos', 'collection', array(
				  'type' 			=> new IngresoType(),
				  'label'			=> 'Ingresos',
				  'by_reference' 	=> false,
				  'prototype' 	=> new Ingreso(),
				  'allow_delete'	=> true,
				  'allow_add'   	=> true,
				  'attr'			=> array(
						'class'		=> 'row ingresos'
				  )
				   
			));  */
			->add('cantidad', 'text',
				  array('mapped'=>false)
			)		
			->add('marca','entity',array(
                'class'=>'BackendAdminBundle:Marca',
                'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                        ->where('u.isDelete = :delete')                        
                        ->setParameter('delete',false)
                        ->orderBy('u.name', 'ASC');                         
            },
                'property'=>'name',
                'multiple'=>false, //un solo deposito por operario
                'mapped' => false
            ))
            ->add('modelo','entity',array(
                'class'=>'BackendAdminBundle:Modelo',
                'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                        ->where('u.isDelete = :delete')                        
                        ->setParameter('delete',false)
                        ->orderBy('u.name', 'ASC');                         
            },
                'property'=>'name',
                'multiple'=>false, //un solo deposito por operario
                'mapped' => false
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
