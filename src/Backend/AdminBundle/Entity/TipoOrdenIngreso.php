<?php

namespace Backend\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="tipo_orden_ingreso")
 * @ORM\Entity()
 */

class TipoOrdenIngreso
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;
    
    /**
     * @ORM\Column(name="is_delete", type="boolean" )
     */
    
    private $isDelete;
    
    /**
     * @ORM\OneToMany(targetEntity="OrdenIngreso", mappedBy="tipo")
     */

    protected $ordenesIngreso;    

     /**
    
    /**
     * Constructor
     */
    public function __construct()
    {
         $this->isDelete=false;
         $this->ordenesIngreso = new ArrayCollection();
             
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
     * Set name
     *
     * @param string $name
     * @return TipoOrdenIngreso
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
  
    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     * @return TipoOrden
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
     * Add ordenes de ingreso
     *
     * @param \Backend\AdminBundle\Entity\OrdenIngreso $ordenesIngreso
     * @return TipoOrdenIngreso
     */
    public function addOrdenIngreso(\Backend\AdminBundle\Entity\OrdenIngreso $ordenesIngreso)
    {
        $this->ordenesIngreso[] = $ordenesIngreso;
    
        return $this;
    }

    /**
     * Remove ordenes de ingreso
     *
     * @param \Backend\AdminBundle\Entity\OrdenIngreso $ordenesIngreso
     */
    public function removeOrdenIngreso(\Backend\AdminBundle\Entity\OrdenIngreso $ordenesIngreso)
    {
        $this->ordenesIngreso->removeElement($ordenesIngreso);
    }

    
    /**
     * Add ordenesIngreso
     *
     * @param \Backend\AdminBundle\Entity\ordenIngreso $ordenesIngreso
     * @return TipoOrdenIngreso
     */
    public function addOrdenesIngreso(\Backend\AdminBundle\Entity\ordenIngreso $ordenesIngreso)
    {
        $this->ordenesIngreso[] = $ordenesIngreso;
    
        return $this;
    }

    /**
     * Remove ordenesIngreso
     *
     * @param \Backend\AdminBundle\Entity\ordenIngreso $ordenesIngreso
     */
    public function removeOrdenesIngreso(\Backend\AdminBundle\Entity\ordenIngreso $ordenesIngreso)
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
}