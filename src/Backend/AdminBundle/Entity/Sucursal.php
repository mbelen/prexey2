<?php

namespace Backend\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="sucursal")
 * @ORM\Entity()
 */

class Sucursal
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
     * @ORM\Column(name="calle", type="string", length=100)
     */
   
    private $calle;

    /**
     * @ORM\Column(name="numero", type="integer")
     */

    private $numero;

    /**
     * @ORM\Column(name="piso", type="integer")
     */    

    private $piso;

    /**
     * @ORM\Column(name="cp", type="string", length=100)
     */
    
    private $cp;

     /**
     * @ORM\Column(name="telefono", type="string", length=100)
     */

    private $telefono;

    /**
     * @ORM\Column(name="fax", type="string", length=100, nullable=true) 
     */   
    
    private $fax;

    /**
     * @ORM\Column(name="email", type="string", length=100, nullable=true) 
     */
    private $email;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    
    private $createdAt;

    /**
     * @ORM\Column(name="modified_at", type="datetime",nullable=true)
     */
    
    private $modifiedAt;

    /**
     * @ORM\OneToMany(targetEntity="AreaTrabajo", mappedBy="sucursal")
     */

    protected $areas;    

     /**
     * @ORM\Column(name="is_delete", type="boolean" )
     */
    private $isDelete;
    
   
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->areas = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
        $this->isDelete=false;       
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
     * @return Sucursal
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
     * @return Sucursal
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
     * Set calle
     *
     * @param string $calle
     * @return Sucursal
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;
    
        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     * @return Sucursal
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    
        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set piso
     *
     * @param integer $piso
     * @return Sucursal
     */
    public function setPiso($piso)
    {
        $this->piso = $piso;
    
        return $this;
    }

    /**
     * Get piso
     *
     * @return integer 
     */
    public function getPiso()
    {
        return $this->piso;
    }

    /**
     * Set cp
     *
     * @param string $cp
     * @return Sucursal
     */
    public function setCp($cp)
    {
        $this->cp = $cp;
    
        return $this;
    }

    /**
     * Get cp
     *
     * @return string 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Sucursal
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    
        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Sucursal
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Sucursal
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @ORM\PreUpdate()
     * 
     */
     
    public function modifiedUpdate(){
    
      $this->setModifiedAt(new \DateTime('now'));
    }  

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Sucursal
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
     * @return Sucursal
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
     * Add areas
     *
     * @param \Backend\AdminBundle\Entity\AreaTrabajo $areas
     * @return Sucursal
     */
    public function addArea(\Backend\AdminBundle\Entity\AreaTrabajo $areas)
    {
        $this->areas[] = $areas;
    
        return $this;
    }

    /**
     * Remove areas
     *
     * @param \Backend\AdminBundle\Entity\AreaTrabajo $areas
     */
    public function removeArea(\Backend\AdminBundle\Entity\AreaTrabajo $areas)
    {
        $this->areas->removeElement($areas);
    }

    /**
     * Get areas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAreas()
    {
        return $this->areas;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     * @return Sucursal
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

   
}