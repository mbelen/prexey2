<?php
 
namespace Backend\AdminBundle\Form\EventListener;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

use Backend\AdminBundle\Entity\Marca;
 
class ModeloSubscriber implements EventSubscriberInterface
{
    private $factory;
 
    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }
 
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND     => 'preBind'
        );
    }
 
    private function addModeloForm($form, $marca)
    {    
        $form->add($this->factory->createNamed('modelo','entity', null, array(
            'class'         => 'BackendAdminBundle:Modelo',
            'empty_value'   => 'Seleccione Modelo',
            'auto_initialize' => false,
            "property"=>"name",
            "required"=>true,
            'query_builder' => function (EntityRepository $repository) use ($marca) {
                $qb = $repository->createQueryBuilder('modelo')
                       ->innerJoin('modelo.marca', 'marca');
                       
                if ($marca instanceof Marca) {
                    $qb->where('modelo.marca = :marca_id')
                    ->setParameter('marca_id', $marca);
                
                } elseif (is_numeric($marca)) {
                    $qb->where('marca.id = :marca_id')
                    ->setParameter('marca_id', $marca);
                } else {
                    $qb->where('marca.name = :marca_id')
                    ->setParameter('marca_id', null);
                }  
                     
                $qb->orderBy('modelo.name');
                return $qb;
            }
        )));
    }
 
    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
      
        $form = $event->getForm();
 
        if (null === $data) {
            return;
        }
 
        $marca = ($data->getModelo()) ? $data->getModelo()->getMarca() : null ;
      
        $this->addModeloForm($form, $marca);
    }
 
    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        if (null === $data) {
            return;
        }
 
       
        $marca = array_key_exists('marca', $data) ? $data['marca'] : null;
        $this->addModeloForm($form, $marca);
    }
}
