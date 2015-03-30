<?php

namespace Backend\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Backend\AdminBundle\Entity\OrdenIngreso;
use Backend\AdminBundle\Entity\Ingreso;
use Backend\AdminBundle\Form\OrdenIngresoType;
use Backend\AdminBundle\Entity\Modelo;

/**
 * OrdenIngreso controller.
 *
 */
class OrdenIngresoController extends Controller
{

     public function generateSQL($search){
     
        $dql="SELECT u FROM BackendAdminBundle:OrdenIngreso u where u.isDelete=false"  ;
        $search=mb_convert_case($search,MB_CASE_LOWER);
        
       
        if ($search)
          $dql.=" and u.id =$search  ";
          
        $dql .=" order by u.id desc"; 
        
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
        return $this->render('BackendAdminBundle:OrdenIngreso:index.html.twig', 
        array('pagination' => $pagination,
        'delete_form' => $deleteForm->createView(),
        'search'=>$search
        ));
        
    }
     else
         throw new AccessDeniedException(); 
    }
    /**
     * Creates a new OrdenIngreso entity.
     *
     */
    public function createAction(Request $request)
    {
        if ( $this->get('security.context')->isGranted('ROLE_ADDARTICULO')) {
        $entity  = new OrdenIngreso();
        $form = $this->createForm(new OrdenIngresoType(), $entity);
        $form->bind($request);
         
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se ha agregado una nueva orden.');
            return $this->redirect($this->generateUrl('ordenIngreso'));
        }
        
        

        return $this->render('BackendAdminBundle:OrdenIngreso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
           
        ));
      }
      else
       throw new AccessDeniedException();
    }
    
    

    /**
    * Creates a form to create a OrdenIngreso entity.
    *
    * @param Articulo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(OrdenIngreso $entity)
    {
        $form = $this->createForm(new OrdenIngresoType(), $entity, array(
            'action' => $this->generateUrl('ordenIngreso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        $form->add('saveAndNew', 'submit', array('label' => 'saveAndNew', 'attr'=> array('id'=>'new', 'class'=>'btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Articulo entity.
     *
     */
     
    public function newAction()
    {
       if ( $this->get('security.context')->isGranted('ROLE_ADDARTICULO')) {
		   
        $entity = new OrdenIngreso();
        $form   = $this->createForm(new OrdenIngresoType(), $entity);

		return $this->render('BackendAdminBundle:OrdenIngreso:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
            
        ));
       }
       else
          throw new AccessDeniedException();
    }
    
   public function procesaAction($id){
	   
       if ( $this->get('security.context')->isGranted('ROLE_MODARTICULO')) { 
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendAdminBundle:OrdenIngreso')->find($id);

        if (!$entity) {
            
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la orden .');
             return $this->redirect($this->generateUrl('ordenIngreso'));
        }

        $estados = $em->getRepository('BackendAdminBundle:Estado')
        ->findAll();
        $marcas = $em->getRepository('BackendAdminBundle:Marca')
        ->findAll(); 
        
        $articulos=$em->getRepository('BackendAdminBundle:Articulo')->findByOrden($id);
        $cantidad=0;
        foreach($entity->getIngresos() as $ingreso){
            $cantidad += $ingreso->getCantidad();
        }
        $cantidad = $cantidad - count($articulos);
       
        return $this->render('BackendAdminBundle:OrdenIngreso:procesa.html.twig', array(
            'entity'      => $entity,
            'marcas' => $marcas,
            'estados'=> $estados,
            'articulos'=>$articulos,
            'cantidad'=>$cantidad
            
        ));
      }
      else
         throw new AccessDeniedException();  
   
   }
   
   /**
    *  Accept orden de ingreso por parte del destino 
    * 
    */
    
    public function toAceptadoAction($id){
		
		if ( $this->get('security.context')->isGranted('ROLE_DELARTICULO')) { 
        
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendAdminBundle:OrdenIngreso')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la orden.');
             
            }
           else{
            
            $estado = $em->getRepository('BackendAdminBundle:EstadoMovimiento')->find(2);
            
            $entity->setEstado($estado); //Aceptada
            $entity->setAcceptedAt(new \DateTime('now'));
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se ha aceptado la orden.');
            
            }        

        return $this->redirect($this->generateUrl('ordenIngreso'));
      }
      else
       throw new AccessDeniedException();					
	} 
	
	/**
	 *  Rechazo de la orden por parte del destino
	 *
	 */ 
	 
	 public function toRechazadoAction($id){
		
		if ( $this->get('security.context')->isGranted('ROLE_DELARTICULO')) { 
        
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendAdminBundle:OrdenIngreso')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la orden.');
             
            }
           else{
            
            $estado = $em->getRepository('BackendAdminBundle:EstadoMovimiento')->find(3);
            
            $entity->setEstado($estado); //Rechazado
            $entity->setacceptedAt(new \DateTime('now'));
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se ha rechazado la orden.');
            
            }        

        return $this->redirect($this->generateUrl('ordenIngreso'));
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

        $entity = $em->getRepository('BackendAdminBundle:OrdenIngreso')->find($id);

        if (!$entity) {
            
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la orden .');
             return $this->redirect($this->generateUrl('ordenIngreso'));
        }

        $editForm = $this->createForm(new OrdenIngresoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendAdminBundle:OrdenIngreso:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            
        ));
      }
      else
         throw new AccessDeniedException(); 
    }

    /**
    * Creates a form to edit a OrdenIngreso entity.
    *                                       
    * @param Articulo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(OrdenIngreso $entity)
    {
        $form = $this->createForm(new OrdenIngresoType(), $entity, array(
            'action' => $this->generateUrl('ordenIngreso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Articulo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        if ( $this->get('security.context')->isGranted('ROLE_MODARTICULO')) {  
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendAdminBundle:OrdenIngreso')->find($id);

        if (!$entity) {
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la orden.');
             return $this->redirect($this->generateUrl('ordenIngreso'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OrdenIngresoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
             $this->get('session')->getFlashBag()->add('success' , 'Se han actualizado los datos de la orden .');
            return $this->redirect($this->generateUrl('ordenIngreso_edit', array('id' => $id)));
        }

        return $this->render('BackendAdminBundle:OrdenIngreso:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            
        ));
      }
      else
         throw new AccessDeniedException();  
    }
    /**
     * Deletes a Articulo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        if ( $this->get('security.context')->isGranted('ROLE_DELARTICULO')) { 
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendAdminBundle:OrdenIngreso')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la orden.');
             
            }
           else{
            
          
            $entity->setIsDelete(true); //baja lógica
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se han borrado los datos de la orden.');
            
            }
        }

        return $this->redirect($this->generateUrl('ordenIngreso'));
      }
      else
       throw new AccessDeniedException(); 
    }
    
    public function printAction(Request $request, $id)
   {
    $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('BackendAdminBundle:OrdenIngreso')->find($id);

      if (!$entity) {
          $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado la orden .');
          return $this->redirect($this->generateUrl('ordenIngreso' ));
      }
      else{
        require_once($this->get('kernel')->getRootDir().'/config/dompdf_config.inc.php');

        $dompdf = new \DOMPDF();
        $html= $this->renderView('BackendAdminBundle:OrdenIngreso:recibo_orden.html.twig',
          array('entity'=>$entity)
        );
        $dompdf->load_html($html);
        $dompdf->render();
        $fileName="recibo_orden_ingreso_".$id.".pdf";
        $response= new Response($dompdf->output(), 200, array(
        	'Content-Type' => 'application/pdf; charset=utf-8'
        ));
        $response->headers->set('Content-Disposition', 'attachment;filename='.$fileName);
        return $response;
      }
   
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
    
    /* Ajax */

  
    public function toProcesadoOrdenAction(Request $request){
						
			$clienteId 		= $request->request->get('cliente');
			$operadorId		= $request->request->get('operador');
			$documento 		= $request->request->get('documento');
			$observaciones 	= $request->request->get('observaciones');
			$destinoId = $request->request->get('destino');
			
			$em = $this->getDoctrine()->getManager();	
									
			$orden = new OrdenIngreso();
			
			$tipo = $em->getRepository('BackendAdminBundle:TipoOrdenIngreso')->findOneById(1);
			
			$orden->setTipo($tipo);
			
			$estado = $em->getRepository('BackendAdminBundle:EstadoMovimiento')->findOneById(1);
							
			$orden->setEstado($estado);
			
			$deposito = $em->getRepository('BackendAdminBundle:Deposito')->findOneById($destinoId);
			
			$area = $deposito->getArea();
			
			$orden->setDeposito($deposito);
			
			$orden->setArea($area);
								
			$cliente = $em->getRepository('BackendAdminBundle:Cliente')->findOneById($clienteId);
			
			$operador = $em->getRepository('BackendAdminBundle:OperadorLogistico')->findOneById($operadorId);
			
									
			$orden->setCliente($cliente);
			$orden->setOperador($operador);
			$orden->setDocumento($documento);
			$orden->setObservaciones($observaciones);
			
							
			$em->persist($orden);
			
			$em->flush();

			$ordenId = $orden->getId();
						
			$data["resultado"] = true;
			$data["id"] = $ordenId;
			$data["estado"] = $estado->getName();
			$data["area"] = $orden->getArea()->getNombre();
			
			$response = new Response(json_encode($data));
			$response->headers->set('Content-Type', 'application/json');
			
			return $response;
	}
    
    
    public function toProcesadoIngresosAction(Request $request){
			
						
			$ordenId 		= $request->request->get('orden');
			$cantidad		= $request->request->get('cantidad');
			$marcaId 		= $request->request->get('marca');
			$modeloId 		= $request->request->get('modelo');
						
			$em = $this->getDoctrine()->getManager();
												
			$marca = $em->getRepository('BackendAdminBundle:Marca')->findOneById($marcaId);
			
			$modelo = $em->getRepository('BackendAdminBundle:Modelo')->findOneById($modeloId);
			
			$orden =  $em->getRepository('BackendAdminBundle:OrdenIngreso')->findOneById($ordenId);
			
			$ingreso = new Ingreso();
						
			$ingreso->setCantidad($cantidad);
			$ingreso->setMarca($marca);
			$ingreso->SetModelo($modelo);	
			$ingreso->setOrden($orden);
							
			$em->persist($ingreso);
			$em->flush();
								
			$data["orden"] = $ordenId;
			$data["resultado"] = true;
									
			$response = new Response(json_encode($data));
			$response->headers->set('Content-Type', 'application/json');
			
			return $response;
	}
	
	public function toRemoveIngresoAction(Request $request){
			
						
			$ordenId 		= $request->request->get('orden');
			$cantidad		= $request->request->get('cantidad');
			$marcaId 		= $request->request->get('marca');
			$modeloId 		= $request->request->get('modelo');
						
			$em = $this->getDoctrine()->getManager();
												
			$marca = $em->getRepository('BackendAdminBundle:Marca')->findOneById($marcaId);
			
			$modelo = $em->getRepository('BackendAdminBundle:Modelo')->findOneById($modeloId);
			
			$orden =  $em->getRepository('BackendAdminBundle:OrdenIngreso')->findOneById($ordenId);
			
			$ingreso = new Ingreso();
						
			$ingreso->setCantidad($cantidad);
			$ingreso->setMarca($marca);
			$ingreso->SetModelo($modelo);	
			$ingreso->setOrden($orden);
								
			$dql = "UPDATE BackendAdminBundle:Ingreso i SET i.isDelete = true where i.orden=".$ordenId." and i.cantidad=".$cantidad." and i.marca=".$marcaId." and i.modelo=".$modeloId;
			
			$query = $em->createQuery($dql);
			
			$result = $query->execute();
							
			//$em->remove($ingreso);
			$em->flush();
			
			$data["query"] = $dql;								
			$data["resultado"] = true;
									
			$response = new Response(json_encode($data));
			$response->headers->set('Content-Type', 'application/json');
			
			return $response;
	}
    
	
	
    
    
    public function toGenerateComboAction(Request $request){
		
		    $items = array();
		
			$marcaId = $request->request->get('marca');
			
			$em = $this->getDoctrine()->getManager();
		
	        $modelos = $em->getRepository('BackendAdminBundle:Modelo')->findBy(array('marca' => $marcaId));
												
			foreach($modelos as $modelo)
			{
				$id = $modelo->getId();
				$nombre = $modelo->getNameManufacture()." ".$modelo->getVariante(); 
				$model = array('id'=>$id,'nombre'=>$nombre);
				$items[] = $model;
			}			
		
			$data['items'] = $items;
			$response = new Response(json_encode($data));
			$response->headers->set('Content-Type', 'application/json');
			
			return $response;
		
	}
    
    public function toGenerateComboMarcaAction(Request $request){
		
		    $items = array();
		
			$marcaId = $request->request->get('marca');
			
			$em = $this->getDoctrine()->getManager();
		
	        $marcas = $em->getRepository('BackendAdminBundle:Marca')->findAll();
												
			foreach($marcas as $marca)
			{
				$id = $marca->getId();
				$nombre = $marca->getName(); 
				$mark = array('id'=>$id,'nombre'=>$nombre);
				$items[] = $mark;
			}			
		
			$data['items'] = $items;
			//$data['resultado'] = true;			
			$response = new Response(json_encode($data));
			$response->headers->set('Content-Type', 'application/json');
			
			return $response;
		
	}
        
    
    /* Generar reportes de Ingresos */
    
    
    
     public function exportarAction(Request $request)
    {
     if ( $this->get('security.context')->isGranted('ROLE_VIEWARTICULO')) {
         
         $em = $this->getDoctrine()->getManager();

       
        $search=$this->generateSQL($request->query->get("search-query")); 
           
       
        $query = $em->createQuery($search);
        
        $excelService = $this->get('xls.service_xls5');
                         
                            
        $excelService->excelObj->setActiveSheetIndex(0)
					->setCellValue('A1', 'Numero Orden')
                    ->setCellValue('B1', 'Fecha Creación')
                    ->setCellValue('C1', 'Cliente')
                    ->setCellValue('D1', 'Operador logistico')  
                    ->setCellValue('E1', 'Documento')
                    ->setCellValue('F1', 'Estado')
                    ->setCellValue('G1','Destino')
                    ->setCellValue('H1','Observaciones') 
                    ->setCellValue('I1','Fecha recepcion/rechazo')                 
                    ;
                    
        $resultados=$query->getResult();
        $i=2;
        foreach($resultados as $r)
        {
           if($r->getEstado()->getId() != 1){
			
			  $recibido =  $r->getAcceptedAt()->format("d-m-Y");  
			   
		   }else{
			   
		      $recibido = "-";   
		   }
           
           $excelService->excelObj->setActiveSheetIndex(0)
						 ->setCellValue("A$i",$r->getId())
                         ->setCellValue("B$i",$r->getCreatedAt()->format("d-m-Y"))
                         ->setCellValue("C$i",$r->getCliente()->getName())
                         ->setCellValue("D$i",$r->getOperador()->getName())
                         ->setCellValue("E$i",$r->getDocumento())
                         ->setCellValue("F$i",$r->getEstado()->getName())
                         ->setCellValue("G$i",$r->getDeposito()->getNombre())
                         ->setCellValue("H$i",$r->getObservaciones())
                         ->setCellValue("I$i",$recibido)
                         
                         ;
          $i++;
        }
                            
        $excelService->excelObj->getActiveSheet()->setTitle('Listado de Ordenes');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $excelService->excelObj->setActiveSheetIndex(0);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $excelService->excelObj->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        
        
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
