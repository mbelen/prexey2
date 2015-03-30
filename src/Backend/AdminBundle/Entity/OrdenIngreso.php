<?php

namespace Backend\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="orden_ingreso")
 * @ORM\Entity()
 */

class OrdenIngreso
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
     
    private $documento; 
    
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */    
     
    private $createdAt;
    
     /**
     * @ORM\Column(name="is_delete", type="boolean" )
     */
     
    private $isDelete;
   
   /**
     * @ORM\ManyToOne(targetEntity="TipoOrdenIngreso", inversedBy="ordenesIngreso")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
    */

    protected $tipo;    
       
    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="ordenesIngreso")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
    */
    
    protected $cliente;
    
     /**
     * @ORM\ManyToOne(targetEntity="OperadorLogistico", inversedBy="ordenesIngreso")
     * @ORM\JoinColumn(name="operador_id", referencedColumnName="id")
    */
        
    protected $operador;     

	/**
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    
    private $observaciones;
          
    /**
     * @ORM\OneToMany(targetEntity="Ingreso", mappedBy="orden")
     */

    protected $ingresos; 
    
    /**   
     * @ORM\ManyToOne(targetEntity="Deposito", inversedBy="ordenesIngreso")
     * @ORM\JoinColumn(name="deposito_id", referencedColumnName="id")
    */

    protected $deposito; 
    
    /**
     * @ORM\ManyToOne(targetEntity="AreaTrabajo", inversedBy="ordenesIngreso")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id")
    */

    protected $area; 
   
 
    /**
     * @ORM\OneToMany(targetEntity="Articulo", mappedBy="orden")
     */
     
     private $articulos;

	/**
     * @ORM\ManyToOne(targetEntity="EstadoMovimiento", inversedBy="ordenes")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
    */

    protected $estado; 
    
    /**
     * @ORM\Column(name="accepted_at", type="datetime",nullable=true)
     */    
     
    private $acceptedAt;

        
    /**
     * Constructor
     */
     
    public function __construct()
    {
         $this->isDelete=false;
         $this->createdAt = new \DateTime('now');
         $this->ingresos =  new ArrayCollection();
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
     * Set cliente
     *
     * @param \Backend\AdminBundle\Entity\Cliente $cliente
     * @return OrdenIngreso
     */
    public function setCliente(\Backend\AdminBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;
    
        return $this;
    }

    /**
     * Get cliente
     *
     * @return \Backend\AdminBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set operador
     *
     * @param \Backend\AdminBundle\Entity\OperadorLogistico $operador
     * @return OrdenIngreso
     */
    public function setOperador(\Backend\AdminBundle\Entity\OperadorLogistico $operador = null)
    {
        $this->operador = $operador;
    
        return $this;
    }

    /**
     * Get operador
     *
     * @return \Backend\AdminBundle\Entity\OperadorLogistico 
     */
    public function getOperador()
    {
        return $this->operador;
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
     * Add ingresos
     *
     * @param \Backend\AdminBundle\Entity\Ingreso $ingresos
     * @return OrdenIngreso
     */
    public function addIngreso(\Backend\AdminBundle\Entity\Ingreso $ingresos)
    {
        $this->ingresos[] = $ingresos;
    
        return $this;
    }

    /**
     * Remove ingresos
     *
     * @param \Backend\AdminBundle\Entity\Ingreso $ingresos
     */
    public function removeIngreso(\Backend\AdminBundle\Entity\Ingreso $ingresos)
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

    /* 
     * Add articulos
     * @param \Backend\AdminBundle\Entity\Articulo $articulos
     * @return OrdenIngreso
     */
     
    public function addArticulo(\Backend\AdminBundle\Entity\Articulo $articulos)
    {
        $this->articulos[] = $articulos;
    
        return $this;
    }


	/*
     * Remove articulos
     *
     * @param \Backend\AdminBundle\Entity\Articulo $articulos
     */
     
    public function removeArticulo(\Backend\AdminBundle\Entity\Articulo $articulos)
    {
        $this->articulos->removeElement($articulos);
    }

    /**
     * Get articulos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticulos()
    {
        return $this->articulos;

    }

    /**
     * Set deposito
     *
     * @param \Backend\AdminBundle\Entity\Deposito $deposito
     * @return OrdenIngreso
     */
    public function setDeposito(\Backend\AdminBundle\Entity\Deposito $deposito = null)
    {
        $this->deposito = $deposito;
    
        return $this;
    }

    /**
     * Get deposito
     *
     * @return \Backend\AdminBundle\Entity\Deposito 
     */
    public function getDeposito()
    {
        return $this->deposito;
    }

    /**
     * Set area
     *
     * @param \Backend\AdminBundle\Entity\AreaTrabajo $area
     * @return OrdenIngreso
     */
    public function setArea(\Backend\AdminBundle\Entity\AreaTrabajo $area = null)
    {
        $this->area = $area;
    
        return $this;
    }

    /**
     * Get area
     *
     * @return \Backend\AdminBundle\Entity\AreaTrabajo 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set estado
     *
     * @param \Backend\AdminBundle\Entity\EstadoMovimiento $estado
     * @return OrdenIngreso
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
     * Set acceptedAt
     *
     * @param \DateTime $acceptedAt
     * @return OrdenIngreso
     */
    public function setAcceptedAt($acceptedAt)
    {
        $this->acceptedAt = $acceptedAt;
    
        return $this;
    }

    /**
     * Get acceptedAt
     *
     * @return \DateTime 
     */
    public function getAcceptedAt()
    {
        return $this->acceptedAt;
    }
}