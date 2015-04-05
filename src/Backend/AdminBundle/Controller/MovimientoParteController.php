<?php

namespace Backend\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Backend\AdminBundle\Entity\MovimientoParte;
use Backend\AdminBundle\Entity\IngresoParte;
use Backend\AdminBundle\Form\MovimientoParteType;

/**
 * Movimiento controller.
 *
 */
class MovimientoParteController extends Controller
{

     public function generateSQL($search){
     
        $dql="SELECT u FROM BackendAdminBundle:MovimientoParte u where u.isDelete=false"  ;
        $search=mb_convert_case($search,MB_CASE_LOWER);
        
        
       /*
        if ($search)
          $dql.=" and u.descripcion like '%$search%' ";
          
        $dql .=" order by u.descripcion"; 
        */
        $dql .=" order by u.id desc";
        
        return $dql;
     
     }

    /**
     * Lists all MovimientoParte entities.
     *
     */
    public function indexAction(Request $request,$search)
    {
       if ( $this->get('security.context')->isGranted('ROLE_VIEWORDENING')) {
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
        return $this->render('BackendAdminBundle:MovimientoParte:index.html.twig', 
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
        if ( $this->get('security.context')->isGranted('ROLE_ADDORDENING')) {
        $entity  = new MovimientoParte();
        $form = $this->createForm(new MovimientoParteType(), $entity);
        $form->bind($request);
         
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se ha agregado un nuevo movimiento.');
            return $this->redirect($this->generateUrl('movimientoParte_edit', array('id' => $entity->getId())));
        }
        
        

        return $this->render('BackendAdminBundle:MovimientoParte:new.html.twig', array(
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
    private function createCreateForm(MovimientoParte $entity)
    {
        $form = $this->createForm(new MovimientoParteType(), $entity, array(
            'action' => $this->generateUrl('movimientoParte_create'),
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
        $entity = new MovimientoParte();
        $form   = $this->createForm(new MovimientoParteType(), $entity);

        return $this->render('BackendAdminBundle:MovimientoParte:new.html.twig', array(
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

        $entity = $em->getRepository('BackendAdminBundle:MovimientoParte')->find($id);

        if (!$entity) {
            
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado el movimiento .');
             return $this->redirect($this->generateUrl('movimientoParte'));
        }

        $editForm = $this->createForm(new MovimientoParteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendAdminBundle:MovimientoParte:edit.html.twig', array(
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
        if ( $this->get('security.context')->isGranted('ROLE_MODORDENING')) {  
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendAdminBundle:MovimientoParte')->find($id);

        if (!$entity) {
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado el movimiento.');
             return $this->redirect($this->generateUrl('movimientoParte'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MovimientoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
             $this->get('session')->getFlashBag()->add('success' , 'Se han actualizado los datos del movimiento.');
            return $this->redirect($this->generateUrl('movimientoParte_edit', array('id' => $id)));
        }

        return $this->render('BackendAdminBundle:MovimientoParte:edit.html.twig', array(
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
        if ( $this->get('security.context')->isGranted('ROLE_DELORDENING')) { 
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendAdminBundle:MovimientoParte')->find($id);

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

        return $this->redirect($this->generateUrl('movimientoParte'));
      }
      else
       throw new AccessDeniedException(); 
    }

    /**
     * Creates a form to delete a Movimiento entity by id.
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
    
    public function detailAction($id){
	   
       if ( $this->get('security.context')->isGranted('ROLE_MODARTICULO')) { 
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendAdminBundle:MovimientoParte')->find($id);

        if (!$entity) {
            
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la orden .');
             return $this->redirect($this->generateUrl('movimientoParte'));
        }
        
        return $this->render('BackendAdminBundle:MovimientoParte:detail.html.twig', array(
            'entity'      => $entity                       
        ));
      }
      else
         throw new AccessDeniedException();  
   
   }    
    
    
    
    /**
    *  Ajax
    **/ 
    
    public function toProcesadoMovimientoAction(Request $request){
						
			$origenId 		= $request->request->get('origen');
			$destinoId		= $request->request->get('destino');
			$documento 		= $request->request->get('documento');
			$observaciones 	= $request->request->get('observaciones');

			
			$em = $this->getDoctrine()->getManager();	
									
			$movimiento = new MovimientoParte();
								
			$origen = $em->getRepository('BackendAdminBundle:Deposito')->findOneById($origenId);
			
			$destino = $em->getRepository('BackendAdminBundle:Deposito')->findOneById($destinoId);
			
			$estado = $em->getRepository('BackendAdminBundle:EstadoMovimiento')->findOneById(1);
						
			$movimiento->setDepositoOrigen($origen);
			$movimiento->setDepositoDestino($destino);
			$movimiento->setDocumento($documento);
			$movimiento->setObservaciones($observaciones);
			$movimiento->setEstado($estado);
										
			$em->persist($movimiento);
			
			$em->flush();

			$movimientoId = $movimiento->getId();
						
			$data["resultado"] = true;
			$data["id"] = $movimientoId;
			
			$response = new Response(json_encode($data));
			$response->headers->set('Content-Type', 'application/json');
			
			return $response;
	}
	
	
	public function toCloseMovimientoAction(Request $request){
		
							  			
			$movimientoId 	= $request->request->get('movimiento');
			$partes		    = $request->request->get('partes');
			
									
			$em = $this->getDoctrine()->getManager();
			$movimiento =  $em->getRepository('BackendAdminBundle:MovimientoParte')->find($movimientoId);
																	
			foreach($partes as $p){
			
				$parte = $em->getRepository('BackendAdminBundle:Parte')->find($p[0]);
				$parte->setStock($p[1]);	
				$em->persist($parte);		
				
				$elemento = new IngresoParte();
						
				$elemento->setCantidad($p[1]);
				$elemento->setParte($parte);
				$elemento->setMovimiento($movimiento);
												
				$em->persist($elemento);
				$em->flush();		
			}
			 
			$data["parte"] = $partes[0][0];
			$data["resultado"] = true;		
					
			$response = new Response(json_encode($data));
			$response->headers->set('Content-Type', 'application/json');
			
			return $response;
	}
	
    
    public function toGenerateComboAction(Request $request){
		
		    $items = array();
							
			$em = $this->getDoctrine()->getManager();
		
	        $partes = $em->getRepository('BackendAdminBundle:Parte')->findAll(); 
												
			foreach($partes as $parte)
			{
				$id = $parte->getId();
				$codigo = $parte->getCodigo();
				$stock = $parte->getStock(); 
				$part = array('id'=>$id,'codigo'=>$codigo,'stock'=>$stock);
				$items[] = $part;
			}			
		
			$data['items'] = $items;
			$response = new Response(json_encode($data));
			$response->headers->set('Content-Type', 'application/json');
			
			return $response;
		
	}
    
    public function toAceptadoAction($id){
		
		if ( $this->get('security.context')->isGranted('ROLE_MODORDENING')) { 
        
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendAdminBundle:MovimientoParte')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado ela movimiento.');
             
            }
           else{
            
            $estado = $em->getRepository('BackendAdminBundle:EstadoMovimiento')->find(2);
            
            $entity->setEstado($estado); //Aceptada
            $entity->setUpdatedAt(new \DateTime('now'));
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se ha aceptado el movimiento.');
            
            }        

        return $this->redirect($this->generateUrl('movimientoParte'));
      }
      else
       throw new AccessDeniedException();					
	} 
    
    
    public function toRechazadoAction($id){
		
		if ( $this->get('security.context')->isGranted('ROLE_DELORDENING')) { 
        
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendAdminBundle:MovimientoParte')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado el movimiento.');
             
            }
           else{
            
            $estado = $em->getRepository('BackendAdminBundle:EstadoMovimiento')->find(3);
            
            $entity->setEstado($estado); //Rechazado
            $entity->setUpdatedAt(new \DateTime('now'));
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se ha rechazado el movimiento.');
            
            }        

        return $this->redirect($this->generateUrl('movimientoParte'));
      }
      else
       throw new AccessDeniedException();					
	}
	
	/**
    *   Print orden de movimiento
    * 
    */ 
    
     public function printAction(Request $request, $id)
   {
    $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('BackendAdminBundle:MovimientoParte')->find($id);

      if (!$entity) {
          $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la orden .');
          return $this->redirect($this->generateUrl('ordenIngreso' ));
      }
      else{
        require_once($this->get('kernel')->getRootDir().'/config/dompdf_config.inc.php');

        $dompdf = new \DOMPDF();
        $html= $this->renderView('BackendAdminBundle:MovimientoParte:recibo_orden.html.twig',
          array('entity'=>$entity)
        );
        $dompdf->load_html($html);
        $dompdf->render();
        $fileName="recibo_movimiento_parte_".$id.".pdf";
        $response= new Response($dompdf->output(), 200, array(
        	'Content-Type' => 'application/pdf; charset=utf-8'
        ));
        $response->headers->set('Content-Disposition', 'attachment;filename='.$fileName);
        return $response;
      }
   
   }
    
     public function exportarAction(Request $request)
    {
     if ( $this->get('security.context')->isGranted('ROLE_VIEWORDENING')) {
         
         $em = $this->getDoctrine()->getManager();

       
        $search=$this->generateSQL($request->query->get("search-query")); 
           
       
        $query = $em->createQuery($search);
        
        $excelService = $this->get('xls.service_xls5');
                         
                            
        $excelService->excelObj->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Fecha Creación')
                    ->setCellValue('B1', 'Origen')
                    ->setCellValue('C1', 'Destino')
                    ->setCellValue('D1', 'Estado')
                    ->setCellValue('E1', 'Observaciones')                    
                    ;
                    
        $resultados=$query->getResult();
        $i=2;
        foreach($resultados as $r)
        {
           $excelService->excelObj->setActiveSheetIndex(0)
                         ->setCellValue("A$i",$r->getCreatedAt()->format("d-m-Y"))
                         ->setCellValue("B$i",$r->getDepositoOrigen()->getNombre())
                         ->setCellValue("C$i",$r->getDepositoDestino()->getNombre())
                         ->setCellValue("D$i",$r->getEstado()->getName())
                         ->setCellValue("E$i",$r->getObservaciones())
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
