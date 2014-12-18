<?php
 
namespace Backend\AdminBundle\Form\EventListener;
 
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

 
class MarcaSubscriber implements EventSubscriberInterface
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
 
    private function addMarcaForm($form, $marca)
    {
        $form->add($this->factory->createNamed('marca', 'entity', $marca, array(
            'class'         => 'BackendAdminBundle:Marca',
            'auto_initialize' => false,
            'empty_value'   => 'Seleccione Marca',
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('marca')
                                  ->orderBy('marca.name');
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
        $this->addMarcaForm($form, $marca);
    }
 
    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        if (null === $data) {
            return;
        }
 
        $marca = array_key_exists('marca', $data) ? $data['marca'] : null;
        $this->addMarcaForm($form, $marca);
    }
}
