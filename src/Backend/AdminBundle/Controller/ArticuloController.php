<?php

namespace Backend\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Backend\AdminBundle\Entity\Articulo;
use Backend\AdminBundle\Form\ArticuloType;
use Doctrine\DBAL\DriverManager;

/**
 * Articulo controller.
 *
 */
class ArticuloController extends Controller
{

     public function generateSQL($search){
     
        $dql="SELECT u FROM BackendAdminBundle:Articulo u JOIN u.marca m where u.isDelete=false"  ;
        $search=mb_convert_case($search,MB_CASE_LOWER);
        
       
        if ($search)
          
          $dql.=" and (u.descripcion like '%$search%' or u.imei like '%$search%' or m.name like '%$search%')";
          
		  $dql .=" order by u.descripcion"; 
        
        return $dql;
     
     }

    /**
     * Lists all Articulo entities.
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
         $estados = $em->getRepository('BackendAdminBundle:Estado')
        ->findAll();
        $deleteForm = $this->createDeleteForm(0);
        return $this->render('BackendAdminBundle:Articulo:index.html.twig', 
        array('pagination' => $pagination,
        'delete_form' => $deleteForm->createView(),
        'search'=>$search ,
        'estados'=>$estados
        ));
        
    }
     else
         throw new AccessDeniedException(); 
    }
    /**
     * Creates a new Cliente entity.
     *
     */
    public function createAction(Request $request)
    {
        if ( $this->get('security.context')->isGranted('ROLE_ADDARTICULO')) {
        $entity  = new Articulo();
        $form = $this->createForm(new ArticuloType(), $entity);
        $form->bind($request);
         
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se ha agregado un nuevo articulo.');
            return $this->redirect($this->generateUrl('articulo_edit', array('id' => $entity->getId())));
        }
        
        

        return $this->render('BackendAdminBundle:Articulo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
           
        ));
      }
      else
       throw new AccessDeniedException();
    }

    public function changeEstadoAction(Request $request){
        if ( $this->get('security.context')->isGranted('ROLE_MODARTICULO')) {
            $ids = $request->request->get("ids");
            $estado_id = $request->request->get("estado"); 
		      	
			     $data=array("msg"=>'');
           try{
             $sql="update articulo set estado_id=$estado_id where id in ($ids)";
             $conn = $this->getDoctrine()->getManager()->getConnection();
             $stmt = $conn->executeUpdate($sql);
             
           }catch(\Exception $e){
              $data["msg"]="No se pudo modificar el estado";
           }
      
			     $response = new Response(json_encode($data));
			     $response->headers->set('Content-Type', 'application/json');
			
			     return $response;
        
        
        }else
          throw new AccessDeniedException();
    
    }


    /**
    * Creates a form to create a Cliente entity.
    *
    * @param Articulo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Articulo $entity)
    {
        $form = $this->createForm(new ArticuloType(), $entity, array(
            'action' => $this->generateUrl('articulo_create'),
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
        $entity = new Articulo();
        $form   = $this->createForm(new ArticuloType(), $entity);

        return $this->render('BackendAdminBundle:Articulo:new.html.twig', array(
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

        $entity = $em->getRepository('BackendAdminBundle:Articulo')->find($id);

        if (!$entity) {
            
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado el articulo .');
             return $this->redirect($this->generateUrl('articulo'));
        }

        $editForm = $this->createForm(new ArticuloType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendAdminBundle:Articulo:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            
        ));
      }
      else
         throw new AccessDeniedException(); 
    }

    /**
    * Creates a form to edit a Articulo entity.
    *                                       
    * @param Articulo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Articulo $entity)
    {
        $form = $this->createForm(new ArticuloType(), $entity, array(
            'action' => $this->generateUrl('articulo_update', array('id' => $entity->getId())),
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

        $entity = $em->getRepository('BackendAdminBundle:Articulo')->find($id);

        if (!$entity) {
             $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado el articulo.');
             return $this->redirect($this->generateUrl('articulo'));
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ArticuloType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
             $this->get('session')->getFlashBag()->add('success' , 'Se han actualizado los datos del articulo .');
            return $this->redirect($this->generateUrl('articulo_edit', array('id' => $id)));
        }

        return $this->render('BackendAdminBundle:Articulo:edit.html.twig', array(
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
            $entity = $em->getRepository('BackendAdminBundle:Articulo')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->add('error' , 'No se ha encontrado el articulo.');
             
            }
           else{
            
          
            $entity->setIsDelete(true); //baja lógica
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success' , 'Se han borrado los datos del articulo.');
            
            }
        }

        return $this->redirect($this->generateUrl('articulo'));
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
    
    public function toProcesadoAction(Request $request){
			
			$marca = explode(",",$request->query->get("marca"));
			$em = $this->getDoctrine()->getManager();                   //TODO: HARDCODEADO
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
    
     public function addArticuloImeiAction(Request $request){
     
        $data=array("mensaje"=>'');
         
        try{ 
            $em = $this->getDoctrine()->getManager();         
            $entity  = new Articulo();
            $entity->setMarca($em->getRepository('BackendAdminBundle:Marca')->find($request->request->get("marca")));
            $entity->setModelo($em->getRepository('BackendAdminBundle:Modelo')->find($request->request->get("modelo")));
            $entity->setImei($request->request->get("imei"));
            $entity->setEstado($em->getRepository('BackendAdminBundle:Estado')->find($request->request->get("estado")));  
            $entity->setGarantia($request->request->get("garantia"));
            $entity->setOrden($em->getRepository('BackendAdminBundle:OrdenIngreso')->find($request->request->get("orden")));
            $em->persist($entity);
            $em->flush();
        
          
        }
        catch(\Exception $e){
            $data["mensaje"]="Error: el IMEI no pudo guardarse. Posiblemente este duplicado.";
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
                    ->setCellValue('C1', 'Disponible')
                    ->setCellValue('D1', 'Descripción')
                    ->setCellValue('E1', 'Observaciones')
                    ;
                    
        $resultados=$query->getResult();
        $i=2;
        foreach($resultados as $r)
        {
            $disponible="No Disponible";
            if ($r->getIsDisponible()){
              $disponible= "Disponible";
            } 
            $tipo="";
            if ($r->getTipo()){
              $tipo=$r->getTipo()->getName();
            }
           $excelService->excelObj->setActiveSheetIndex(0)
                         ->setCellValue("A$i",$r->getCreatedAt()->format("d-m-Y"))
                         ->setCellValue("B$i",$tipo)
                         ->setCellValue("C$i",$disponible)
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
        
        
        $fileName="articulos_".date("Ymd").".xls";
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
