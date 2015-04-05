<?php

namespace Backend\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="movimiento_parte")
 * @ORM\Entity()
 */

class MovimientoParte
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    
    private $id;
 
     /**
     * @ORM\Column(name="documento", type="string", length=100)
     */
     
    protected $documento; 
    
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */    
     
    private $createdAt;
  
     /**
     * @ORM\Column(name="is_delete", type="boolean" )
     */
     
    private $isDelete;
   
   /**
     * @ORM\ManyToOne(targetEntity="Deposito", inversedBy="movimientosPartesDestino")
     * @ORM\JoinColumn(name="destino_id", referencedColumnName="id")
    */

    protected $depositoDestino;
    
	/**
     * @ORM\ManyToOne(targetEntity="Deposito", inversedBy="movimientosPartesOrigen")
     * @ORM\JoinColumn(name="origen_id", referencedColumnName="id")
    */

    protected $depositoOrigen;    
    
    /**
     * @ORM\OneToMany(targetEntity="IngresoParte", mappedBy="movimiento")
     */

    protected $ingresos; 

    /**
     * @ORM\ManyToMany(targetEntity="Parte", mappedBy="movimientos")
     */    
	
    private $partes;
            
    
	/**
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
     private $observaciones;
   
     /**
     * @ORM\ManyToOne(targetEntity="EstadoMovimiento", inversedBy="movimientosParte")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
	 */

     protected $estado; 

	 /**
     * @ORM\Column(name="updated_at", type="datetime",nullable=true)
     */    
     
    private $updatedAt;
    	
    
    
    /**
     * Constructor
     */
     
    public function __construct()
    {
         $this->isDelete=false;
         $this->createdAt = new \DateTime('now');
         $this->articulos = new ArrayCollection();            
    }
     

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Orden de Ingreso
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     * @return Orden de Ingreso
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;
    
        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean 
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Articulo
     */
    public function setObservacion($observaciones)
    {
        $this->observaciones = $observaciones;
   
        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set tipo
     *
     * @param \Backend\AdminBundle\Entity\TipoOrdenIngreso $tipo
     * @return OrdenIngreso
     */
    public function setTipo(\Backend\AdminBundle\Entity\TipoOrdenIngreso $tipo = null)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return \Backend\AdminBundle\Entity\TipoOrdenIngreso 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return OrdenIngreso
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }


    /**
     * Set documento
     *
     * @param string $documento
     * @return OrdenIngreso
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    
        return $this;
    }

    /**
     * Get documento
     *
     * @return string 
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Add productos
     *
     * @param \Backend\AdminBundle\Entity\Producto $productos
     * @return OrdenIngreso
     */
    public function addProducto(\Backend\AdminBundle\Entity\Producto $productos)
    {
        $this->productos[] = $productos;
    
        return $this;
    }

    /**
     * Remove productos
     *
     * @param \Backend\AdminBundle\Entity\Producto $productos
     */
    public function removeProducto(\Backend\AdminBundle\Entity\Producto $productos)
    {
        $this->productos->removeElement($productos);
    }

    /**
     * Get productos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductos()
    {
        return $this->productos;
    }

    /**
     * Set depositoDestino
     *
     * @param \Backend\AdminBundle\Entity\Deposito $depositoDestino
     * @return Movimiento
     */
    public function setDepositoDestino(\Backend\AdminBundle\Entity\Deposito $depositoDestino = null)
    {
        $this->depositoDestino = $depositoDestino;
    
        return $this;
    }

    /**
     * Get depositoDestino
     *
     * @return \Backend\AdminBundle\Entity\Deposito 
     */
    public function getDepositoDestino()
    {
        return $this->depositoDestino;
    }

    /**
     * Set depositoOrigen
     *
     * @param \Backend\AdminBundle\Entity\Deposito $depositoOrigen
     * @return Movimiento
     */
    public function setDepositoOrigen(\Backend\AdminBundle\Entity\Deposito $depositoOrigen = null)
    {
        $this->depositoOrigen = $depositoOrigen;
    
        return $this;
    }

    /**
     * Get depositoOrigen
     *
     * @return \Backend\AdminBundle\Entity\Deposito 
     */
    public function getDepositoOrigen()
    {
        return $this->depositoOrigen;
    }

   
    /**
     * Add observaciones
     *
     * @param \Backend\AdminBundle\Entity\Movimiento $observaciones
     * @return Movimiento
     */
    public function addObservacione(\Backend\AdminBundle\Entity\Movimiento $observaciones)
    {
        $this->observaciones[] = $observaciones;
    
        return $this;
    }

    /**
     * Remove observaciones
     *
     * @param \Backend\AdminBundle\Entity\Movimiento $observaciones
     */
    public function removeObservacione(\Backend\AdminBundle\Entity\Movimiento $observaciones)
    {
        $this->observaciones->removeElement($observaciones);
    }


    /**
     * Add partes
     *
     * @param \Backend\AdminBundle\Entity\Parte $partes
     * @return MovimientoParte
     */
    public function addParte(\Backend\AdminBundle\Entity\Parte $partes)
    {
        $this->partes[] = $partes;
    
        return $this;
    }

    /**
     * Remove partes
     *
     * @param \Backend\AdminBundle\Entity\Parte $partes
     */
    public function removeParte(\Backend\AdminBundle\Entity\Parte $partes)
    {
        $this->partes->removeElement($partes);
    }

    /**
     * Get partes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPartes()
    {
        return $this->partes;
    }

    /**
     * Set estado
     *
     * @param \Backend\AdminBundle\Entity\EstadoMovimiento $estado
     * @return MovimientoParte
     */
    public function setEstado(\Backend\AdminBundle\Entity\EstadoMovimiento $estado = null)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return \Backend\AdminBundle\Entity\EstadoMovimiento 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return MovimientoParte
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add ingresos
     *
     * @param \Backend\AdminBundle\Entity\IngresoParte $ingresos
     * @return MovimientoParte
     */
    public function addIngreso(\Backend\AdminBundle\Entity\IngresoParte $ingresos)
    {
        $this->ingresos[] = $ingresos;
    
        return $this;
    }

    /**
     * Remove ingresos
     *
     * @param \Backend\AdminBundle\Entity\IngresoParte $ingresos
     */
    public function removeIngreso(\Backend\AdminBundle\Entity\IngresoParte $ingresos)
    {
        $this->ingresos->removeElement($ingresos);
    }

    /**
     * Get ingresos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngresos()
    {
        return $this->ingresos;
    }
}
