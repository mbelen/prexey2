<?php

namespace Backend\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Backend\AdminBundle\Form\EventListener\MarcaSubscriber;
use Backend\AdminBundle\Form\EventListener\ModeloSubscriber;


class IngresoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cantidad')
            ->add('tipo', 'entity',array(
            'class'=>'BackendAdminBundle:TipoArticulo',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder("u")
                         ->select("u")
                         ->where('u.parent != :null')
                         ->setParameter('null',false)                        
                         ->orderBy('u.name', 'ASC');
                      
            }));
            $marcaSubscriber = new MarcaSubscriber($builder->getFormFactory());
			$builder->addEventSubscriber($marcaSubscriber);
        
			$modeloSubscriber = new ModeloSubscriber($builder->getFormFactory());
			$builder->addEventSubscriber($modeloSubscriber);
            /*
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
            ));                        
            */
       }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Backend\AdminBundle\Entity\Ingreso'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backend_adminbundle_ingreso';
    }
}
