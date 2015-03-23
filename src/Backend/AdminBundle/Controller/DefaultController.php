<?php

namespace Backend\AdminBundle\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
       if ( $this->get('security.context')->isGranted('ROLE_VISITOR')) {
        
           return $this->render('BackendAdminBundle:Default:index.html.twig');
       }
       
       else if ( $this->get('security.context')->isGranted('ROLE_POS')) {
        
           
           return $this->redirect($this->generateUrl('articulo'));
           //return $this->render('BackendAdminBundle:Default:index.html.twig');
       }
             
       else
           
           return $this->redirect($this->generateUrl('user'));
                
    }
    
    public function accessAction()
    {
       $this->get('session')->getFlashBag()->add('error' , 'Su usuario no tiene acceso a esta sección.');    
      return $this->redirect($this->generateUrl('login'));
    }
    
    public function blankAction()
    {
           
      return $this->render('BackendAdminBundle:Default:blank.html.twig');
    } 
    
    
}
