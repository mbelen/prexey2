<?php

namespace Backend\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Backend\AdminBundle\Entity\Parte;
use Backend\AdminBundle\Form\ParteType;

/**
 * Parte controller.
 *
 */
class ParteController extends Controller
{

     public function generateSQL($search){
     
        $dql="SELECT u FROM BackendAdminBundle:Parte u where u.isDelete=false"  ;
        $search=mb_convert_case($search,MB_CASE_LOWER);
        
       
        if ($search)
          $dql.=" and u.nombre_interno like '%$search%' ";
          
        $dql .=" order by u.nombre_interno"; 
        
        return $dql;
     
     }

    /**
     * Lists all Parte entities.
     *
     */
    public function indexAction(Request $request,$search)
    {
       if ( $this->get('security.context')->isGranted('ROLE_VIEWARTICULO')) {
        $em = $this->getDoctrine()->getManager();
        
        $dql=$this->generateSQL($search);
        $query = $em->createQuery($dql);
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $query,
        $this->get('request')->query->get('page', 1)/*page number*/,
        $this->container->getParameter('max_on_listepage')/*limit per page*/
    );
        
        $deleteForm = $this->createDeleteForm(0);
        return $this->render('BackendAdminBundle:Parte:index.html.twig', 
        array('pagination' => $pagination,
        'delete_form' => $deleteForm->createView(),
        'search'=>$search
        ));
        
    }
     else
         throw new AccessDeniedException(); 
    }
    /**
     * Creates a new Parte entity.
     *
     */
    public function createAction(Request $request)
    {
        if ( $this->get('security.context')->isGranted('ROLE_ADDARTICULO')) {
        $entity  = new Parte();
        $form = $this->createForm(new ParteType(), $entity);
        $form->bind($request);
         
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se ha agregado una nueva parte.');
            return $this->redirect($this->generateUrl('parte_edit', array('id' => $entity->getId())));
        }
        
        

        return $this->render('BackendAdminBundle:Parte:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
           
        ));
      }
      else
       throw new AccessDeniedException();
    }

    /**
    * Creates a form to create a Parte entity.
    *
    * @param Parte $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Parte $entity)
    {
        $form = $this->createForm(new ParteType(), $entity, array(
            'action' => $this->generateUrl('parte_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Parte entity.
     *
     */
    public function newAction()
    {
       if ( $this->get('security.context')->isGranted('ROLE_ADDARTICULO')) {
        $entity = new Parte();
        $form   = $this->createForm(new ParteType(), $entity);

        return $this->render('BackendAdminBundle:Parte:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
            
        ));
       }
       else
          throw new AccessDeniedException();
    }

  
    /**
     * Displays a form to edit an existing Parte entity.
     *
     */
    public function editAction($id)
    {
        if ( $this->get('security.context')->isGranted('ROLE_MODARTICULO')) { 
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendAdminBundle:Parte')->find($id);

        if (!$entity) {
            
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la parte.');
             return $this->redirect($this->generateUrl('parte'));
        }

        $editForm = $this->createForm(new ParteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendAdminBundle:Parte:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            
        ));
      }
      else
         throw new AccessDeniedException(); 
    }

    /**
    * Creates a form to edit a Parte entity.
    *                                       
    * @param Parte $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Parte $entity)
    {
        $form = $this->createForm(new ParteType(), $entity, array(
            'action' => $this->generateUrl('parte_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    /**
     * Edits an existing Parte entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        if ( $this->get('security.context')->isGranted('ROLE_MODARTICULO')) {  
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendAdminBundle:Parte')->find($id);

        if (!$entity) {
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la parte.');
             return $this->redirect($this->generateUrl('parte'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ParteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
             $this->get('session')->getFlashBag()->add('success' , 'Se han actualizado los datos de la parte.');
            return $this->redirect($this->generateUrl('parte_edit', array('id' => $id)));
        }

        return $this->render('BackendAdminBundle:Parte:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            
        ));
      }
      else
         throw new AccessDeniedException();  
    }
    /**
     * Deletes a Parte entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        if ( $this->get('security.context')->isGranted('ROLE_DELARTICULO')) { 
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendAdminBundle:Parte')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la parte.');
             
            }
           else{
            
          
            $entity->setIsDelete(true); //baja lógica
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se han borrado los datos de la parte.');
            
            }
        }

        return $this->redirect($this->generateUrl('parte'));
      }
      else
       throw new AccessDeniedException(); 
    }

    /**
     * Creates a form to delete a Parte entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    public function toProcesadoAction(Request $request){
			
			$marca = explode(",",$request->query->get("marca"));
			$em = $this->getDoctrine()->getManager();
			$modelos = $em->getRepository('BackendAdminBundle:Modelo')->findOneById(1); // Bymarca_id($marca);
			if(!$modelos){
				$data["modelo"]= false;
			}else{
				$modelo = $modelos->getName(); 
				$id = $producto->getId();
				$data["id"]=$id;
				$data["modelo"] = $modelo; 	
			}
			$response = new Response(json_encode($data));
			$response->headers->set('Content-Type', 'application/json');
			
			return $response;
	}
    
    
    
     public function exportarAction(Request $request)
    {
     if ( $this->get('security.context')->isGranted('ROLE_VIEWARTICULO')) {
         
         $em = $this->getDoctrine()->getManager();

       
        $search=$this->generateSQL($request->query->get("search-query")); 
           
       
        $query = $em->createQuery($search);
        
        $excelService = $this->get('xls.service_xls5');
                         
                            
        $excelService->excelObj->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Fecha Creación')
                    ->setCellValue('B1', 'Tipo')
                    ->setCellValue('C1', 'Codigo')
                    ->setCellValue('D1', 'Nombre Fabricante')
                    ->setCellValue('E1', 'Nombre Interno')
                    ;
                    
        $resultados=$query->getResult();
        $i=2;
        foreach($resultados as $r)
        {
           $excelService->excelObj->setActiveSheetIndex(0)
                         ->setCellValue("A$i",$r->getCreatedAt()->format("d-m-Y"))
                         ->setCellValue("B$i",$r->getTipo()->getName())
                         ->setCellValue("C$i",$r->getDisponible())
                         ->setCellValue("D$i",$r->getDescripcion())
                         ->setCellValue("E$i",$r->getObservacion())
                         ;
          $i++;
        }
                            
        $excelService->excelObj->getActiveSheet()->setTitle('Listado de Articulos');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $excelService->excelObj->setActiveSheetIndex(0);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        
        
        $fileName="partes_".date("Ymd").".xls";
        //create the response
        $response = $excelService->getResponse();
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        //$response->headers->set('Content-Disposition', 'filename='.$fileName);
        echo header("Content-Disposition: attachment; filename=$fileName");
        // If you are using a https connection, you have to set those two headers and use sendHeaders() for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->sendHeaders();
        return $response; 
        
        
        }
        else{
           throw new AccessDeniedException(); 
        }
    }
    
    
}
