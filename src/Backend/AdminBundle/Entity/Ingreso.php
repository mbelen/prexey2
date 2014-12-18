<?php

namespace Backend\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="ingreso")
 * @ORM\Entity()
 */

class Ingreso
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    
    private $id;
 
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    
     /**
     * @ORM\Column(name="is_delete", type="boolean" )
     */
    private $isDelete;
    
     /**
     * @ORM\Column(name="cantidad", type="integer" )
     */    
    
    private $cantidad;
    
   /**
     * @ORM\ManyToOne(targetEntity="TipoArticulo", inversedBy="ingresos")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
     */

    protected $tipo;    
            
    /**
     * @ORM\ManyToOne(targetEntity="Marca", inversedBy="ingresos")
     * @ORM\JoinColumn(name="marca_id", referencedColumnName="id")
     */    
    
    protected $marca;
           
    /**
     * @ORM\ManyToOne(targetEntity="Modelo", inversedBy="ingresos")
     * @ORM\JoinColumn(name="modelo_id", referencedColumnName="id")
     */ 
      
    public $modelo;
    
    /**
     * @ORM\ManyToOne(targetEntity="OrdenIngreso", inversedBy="ingresos")
     * @ORM\JoinColumn(name="orden_id", referencedColumnName="id")
     */
        
    protected $orden;
			
		         
    /**
     * Constructor
     */
    public function __construct()
    {
         $this->isDelete=false;
         $this->isValido=true;
         $this->createdAt = new \DateTime('now');
   
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
     * @return Ingreso
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
     * @return Ingreso
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
     * Set tipo
     *
     * @param \Backend\AdminBundle\Entity\TipoArticulo $tipo
     * @return Ingreso
     */
    public function setTipo(\Backend\AdminBundle\Entity\TipoArticulo $tipo = null)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return \Backend\AdminBundle\Entity\TipoArticulo 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set estado
     *
     * @param \Backend\AdminBundle\Entity\Estado $estado
     * @return Ingreso
     */
    public function setEstado(\Backend\AdminBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;
    
        return $this;
    }

    /**
     * Get estado
     *
     * @return \Backend\AdminBundle\Entity\Estado 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set marca
     *
     * @param \Backend\AdminBundle\Entity\Marca $marca
     * @return Ingreso
     */
    public function setMarca(\Backend\AdminBundle\Entity\Marca $marca = null)
    {
        $this->marca = $marca;
    
        return $this;
    }

    /**
     * Get marca
     *
     * @return \Backend\AdminBundle\Entity\Marca 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set modelo
     *
     * @param \Backend\AdminBundle\Entity\Modelo $modelo
     * @return Ingreso
     */
    public function setModelo(\Backend\AdminBundle\Entity\Modelo $modelo = null)
    {
        $this->modelo = $modelo;
    
        return $this;
    }

    /**
     * Get modelo
     *
     * @return \Backend\AdminBundle\Entity\Modelo 
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set orden
     *
     * @param \Backend\AdminBundle\Entity\Orden $orden
     * @return Ingreso
     */
    public function setOrden(\Backend\AdminBundle\Entity\Orden $orden = null)
    {
        $this->orden = $orden;
    
        return $this;
    }

    /**
     * Get orden
     *
     * @return \Backend\AdminBundle\Entity\Orden 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Ingreso
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    
        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }
}