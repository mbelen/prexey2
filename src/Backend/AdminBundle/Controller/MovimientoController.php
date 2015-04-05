<?php

namespace Backend\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Backend\AdminBundle\Entity\Movimiento;
use Backend\AdminBundle\Form\MovimientoType;

/**
 * Movimiento controller.
 *
 */
class MovimientoController extends Controller
{

     public function generateSQL($search){
     
        $dql="SELECT u FROM BackendAdminBundle:Movimiento u where u.isDelete=false"  ;
        $search=mb_convert_case($search,MB_CASE_LOWER);
        
       /*
        if ($search)
          $dql.=" and u.descripcion like '%$search%' ";
          
        $dql .=" order by u.descripcion"; 
        */
        return $dql;
     
     }

    /**
     * Lists all OrdenIngreso entities.
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
        return $this->render('BackendAdminBundle:Movimiento:index.html.twig', 
        array('pagination' => $pagination,
        'delete_form' => $deleteForm->createView(),
        'search'=>$search
        ));
        
    }
     else
         throw new AccessDeniedException(); 
    }
    /**
     * Creates a new Movimiento entity.
     *
     */
    public function createAction(Request $request)
    {
        if ( $this->get('security.context')->isGranted('ROLE_ADDARTICULO')) {
        $entity  = new Movimiento();
        $form = $this->createForm(new MovimientoType(), $entity);
        $form->bind($request);
         
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se ha agregado un nuevo movimiento.');
            return $this->redirect($this->generateUrl('movimiento_edit', array('id' => $entity->getId())));
        }
        
        

        return $this->render('BackendAdminBundle:Movimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
           
        ));
      }
      else
       throw new AccessDeniedException();
    }

    /**
    * Creates a form to create a Cliente entity.
    *
    * @param Articulo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Movimiento $entity)
    {
        $form = $this->createForm(new MovimientoType(), $entity, array(
            'action' => $this->generateUrl('movimiento_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Articulo entity.
     *
     */
    public function newAction()
    {
       if ( $this->get('security.context')->isGranted('ROLE_ADDARTICULO')) {
        $entity = new Movimiento();
        $form   = $this->createForm(new MovimientoType(), $entity);

        return $this->render('BackendAdminBundle:Movimiento:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
            
        ));
       }
       else
          throw new AccessDeniedException();
    }

  
    /**
     * Displays a form to edit an existing Articulo entity.
     *
     */
    public function editAction($id)
    {
        if ( $this->get('security.context')->isGranted('ROLE_MODARTICULO')) { 
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendAdminBundle:Movimiento')->find($id);

        if (!$entity) {
            
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado el movimiento .');
             return $this->redirect($this->generateUrl('movimiento'));
        }

        $editForm = $this->createForm(new ArticuloType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendAdminBundle:Movimiento:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            
        ));
      }
      else
         throw new AccessDeniedException(); 
    }

    /**
    * Creates a form to edit a Movimiento entity.
    *                                       
    * @param Movimiento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Movimiento $entity)
    {
        $form = $this->createForm(new MovimientoType(), $entity, array(
            'action' => $this->generateUrl('movimiento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Movimiento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        if ( $this->get('security.context')->isGranted('ROLE_MODARTICULO')) {  
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendAdminBundle:Movimiento')->find($id);

        if (!$entity) {
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado el movimiento.');
             return $this->redirect($this->generateUrl('movimiento'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MovimientoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
             $this->get('session')->getFlashBag()->add('success' , 'Se han actualizado los datos del movimiento.');
            return $this->redirect($this->generateUrl('movimiento_edit', array('id' => $id)));
        }

        return $this->render('BackendAdminBundle:Movimiento:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            
        ));
      }
      else
         throw new AccessDeniedException();  
    }
    /**
     * Deletes a Movimiento entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        if ( $this->get('security.context')->isGranted('ROLE_DELARTICULO')) { 
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendAdminBundle:Movimiento')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado el movimiento.');
             
            }
           else{
            
          
            $entity->setIsDelete(true); //baja lógica
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se han borrado los datos del movimiento.');
            
            }
        }

        return $this->redirect($this->generateUrl('movimiento'));
      }
      else
       throw new AccessDeniedException(); 
    }

    /**
     * Creates a form to delete a Articulo entity by id.
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
   
    /** 
     * 
     */
     
     public function toProcesadoAction(Request $request){
		 
			$destinoId 		= $request->request->get('destino');
			$origenId		= $request->request->get('origen');
			$documento 		= $request->request->get('documento');
			$observaciones 	= $request->request->get('observaciones');
			$articulos 	    = $request->request->get('articulos');

			$em = $this->getDoctrine()->getManager();
		 
			$destino = $em->getRepository('BackendAdminBundle:Deposito')->find($destinoId);
			
			$origen =  $em->getRepository('BackendAdminBundle:Movimiento')->find($origenId);
			
			$movimiento = new Movimiento();
			
			$movimiento->setDepositoDestino($destino);
			$movimiento->setDepositoOrigen($origen);
			$movimiento->setDocumento($documento);
			
			if($observaciones) { $movimiento->setObservaciones(); }
			
			foreach($articulos as $art){
				
				$articulo = $em->getRepository('BackendAdminBundle:Articulo')->findByImei($art);	
				$movimiento->addArticulos($articulo);
			
			}
			
			$em->persist($movimiento);
            $em->flush();
            
            $data["resultado"] = true;
						
			$response = new Response(json_encode($data));
			$response->headers->set('Content-Type', 'application/json');
			
			return $response;
		 					 
	} 
	
	public function toValidateImeiAction(Request $request){
		 
			$imei = $request->request->get('imei');
			
			//$dql="SELECT u FROM BackendAdminBundle:Articulo u where u.imei = '$imei'";
			/*
			$em = $this->getDoctrine()->getManager();
			$articulo = $em->createQuery($dql)->getResult();        
           
            if($articulo){
            
				$data["resultado"] = true;
				$data["marca"] = $dql;
            
			}else{
				
				$data["resultado"] = false;	
			}
			*/
			
			$data["resultado"] = $true;
			$data["imei"] = $imei;			
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
                    ->setCellValue('C1', 'Cliente')
                    ->setCellValue('D1', 'Observaciones')                    
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
                            
        $excelService->excelObj->getActiveSheet()->setTitle('Listado de Movimientos');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $excelService->excelObj->setActiveSheetIndex(0);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        
        
        $fileName="ordenes_".date("Ymd").".xls";
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
