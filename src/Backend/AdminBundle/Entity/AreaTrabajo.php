<?php

namespace Backend\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="area")
 * @ORM\Entity()
 */
class AreaTrabajo
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @ORM\Column(name="responsable", type="string", length=100)
     */
    private $responsable;

    /**
     * @ORM\Column(name="observaciones", type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

     /**
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * @ORM\Column(name="is_habilitada", type="boolean" )
     */
    private $isHabilitada;
    
    /**
     * @ORM\ManyToOne(targetEntity="Sucursal", inversedBy="areas")
     * @ORM\JoinColumn(name="sucursal_id", referencedColumnName="id")
     */
    private $sucursal;
    
    /**
     * @ORM\Column(name="is_delete", type="boolean" )
     */

    private $isDelete;
   
     /**
     * @ORM\ManyToMany(targetEntity="TipoDeposito", inversedBy="areasTrabajo")
     * @ORM\JoinTable(name="areas_depositos")
     */
     
	 private $tipoDepositos;
	
	/**
     * @ORM\OneToMany(targetEntity="Deposito", mappedBy="area")
     */

    protected $depositos;        
	
	  
    /**
     * @ORM\OneToMany(targetEntity="OrdenIngreso", mappedBy="area")
     */

    protected $ordenesIngreso;   
    
    /**
     * @ORM\OneToMany(targetEntity="OrdenIngresoParte", mappedBy="area")
     */

    protected $ordenesIngresoParte;        
   

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isHabilitada=true;
        $this->isDelete=false;
        $this->createdAt = new \DateTime('now');
        //$this->depositos = new ArrayCollection();       
    }    

	public function __toString()
    {
      return mb_convert_case($this->name, MB_CASE_TITLE,"UTF-8");
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
     * Set nombre
     *
     * @param string $nombre
     * @return AreaTrabajo
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     * @return AreaTrabajo
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
    
        return $this;
    }

    /**
     * Get responsable
     *
     * @return string 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return AreaTrabajo
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return AreaTrabajo
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
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     * @return AreaTrabajo
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    
        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime 
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * Set isHabilitada
     *
     * @param boolean $isHabilitada
     * @return AreaTrabajo
     */
    public function setIsHabilitada($isHabilitada)
    {
        $this->isHabilitada = $isHabilitada;
    
        return $this;
    }

    /**
     * Get isHabilitada
     *
     * @return boolean 
     */
    public function getIsHabilitada()
    {
        return $this->isHabilitada;
    }

    /**
     * Set sucursal
     *
     * @param \Backend\AdminBundle\Entity\Sucursal $sucursal
     * @return AreaTrabajo
     */
    public function setSucursal(\Backend\AdminBundle\Entity\Sucursal $sucursal = null)
    {
        $this->sucursal = $sucursal;
    
        return $this;
    }

    /**
     * Get sucursal
     *
     * @return \Backend\AdminBundle\Entity\Sucursal 
     */
    public function getSucursal()
    {
        return $this->sucursal;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     * @return AreaTrabajo
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
     * Add depositos
     *
     * @param \Backend\AdminBundle\Entity\TipoDeposito $depositos
     * @return AreaTrabajo
     */
    public function addDeposito(\Backend\AdminBundle\Entity\TipoDeposito $depositos)
    {
        $this->depositos[] = $depositos;
    
        return $this;
    }

    /**
     * Remove depositos
     *
     * @param \Backend\AdminBundle\Entity\TipoDeposito $depositos
     */
    public function removeDeposito(\Backend\AdminBundle\Entity\TipoDeposito $depositos)
    {
        $this->depositos->removeElement($depositos);
    }

    /**
     * Get depositos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDepositos()
    {
        return $this->depositos;
    }

    /**
     * Add ordenesIngreso
     *
     * @param \Backend\AdminBundle\Entity\OrdenIngreso $ordenesIngreso
     * @return AreaTrabajo
     */
    public function addOrdenesIngreso(\Backend\AdminBundle\Entity\OrdenIngreso $ordenesIngreso)
    {
        $this->ordenesIngreso[] = $ordenesIngreso;
    
        return $this;
    }

    /**
     * Remove ordenesIngreso
     *
     * @param \Backend\AdminBundle\Entity\OrdenIngreso $ordenesIngreso
     */
    public function removeOrdenesIngreso(\Backend\AdminBundle\Entity\OrdenIngreso $ordenesIngreso)
    {
        $this->ordenesIngreso->removeElement($ordenesIngreso);
    }

    /**
     * Get ordenesIngreso
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrdenesIngreso()
    {
        return $this->ordenesIngreso;
    }
   
    /**
     * Add tipoDepositos
     *
     * @param \Backend\AdminBundle\Entity\TipoDeposito $tipoDepositos
     * @return AreaTrabajo
     */
    public function addTipoDeposito(\Backend\AdminBundle\Entity\TipoDeposito $tipoDepositos)
    {
        $this->tipoDepositos[] = $tipoDepositos;
    
        return $this;
    }

    /**
     * Remove tipoDepositos
     *
     * @param \Backend\AdminBundle\Entity\TipoDeposito $tipoDepositos
     */
    public function removeTipoDeposito(\Backend\AdminBundle\Entity\TipoDeposito $tipoDepositos)
    {
        $this->tipoDepositos->removeElement($tipoDepositos);
    }

    /**
     * Get tipoDepositos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTipoDepositos()
    {
        return $this->tipoDepositos;
    }

    /**
     * Add ordenesIngresoParte
     *
     * @param \Backend\AdminBundle\Entity\OrdenIngresoParte $ordenesIngresoParte
     * @return AreaTrabajo
     */
    public function addOrdenesIngresoParte(\Backend\AdminBundle\Entity\OrdenIngresoParte $ordenesIngresoParte)
    {
        $this->ordenesIngresoParte[] = $ordenesIngresoParte;
    
        return $this;
    }

    /**
     * Remove ordenesIngresoParte
     *
     * @param \Backend\AdminBundle\Entity\OrdenIngresoParte $ordenesIngresoParte
     */
    public function removeOrdenesIngresoParte(\Backend\AdminBundle\Entity\OrdenIngresoParte $ordenesIngresoParte)
    {
        $this->ordenesIngresoParte->removeElement($ordenesIngresoParte);
    }

    /**
     * Get ordenesIngresoParte
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrdenesIngresoParte()
    {
        return $this->ordenesIngresoParte;
    }
}