<?php

namespace Backend\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="tipo_articulo")
 * @ORM\Entity()
 */

class TipoArticulo
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
     * @ORM\OneToMany(targetEntity="Ingreso", mappedBy="tipo")
     */
     
     protected $ingresos;
     
     
    /**
     * @ORM\OneToMany(targetEntity="TipoArticulo", mappedBy="parent")
     **/

    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="TipoArticulo", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     **/
      
    private $parent; 
    /**
     * @ORM\OneToMany(targetEntity="Articulo", mappedBy="tipo")
     **/

    protected $articulos;    

        


   
    /**
     * Constructor
     */
    public function __construct()
    {
         $this->isDelete=false;
         $this->isValido=true;
         $this->articulos = new ArrayCollection();
         $this->ingresos = new ArrayCollection();
         $this->children = new  ArrayCollection();
             
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
     * @return TipoArticulo
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
     * Set isValido
     *
     * @param boolean $isValido
     * @return TipoArticulo
     */
    public function setIsValido($isValido)
    {
        $this->isValido = $isValido;
    
        return $this;
    }

    /**
     * Get isValido
     *
     * @return boolean 
     */
    public function getIsValido()
    {
        return $this->isValido;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     * @return TipoArticulo
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
     * Add articulos
     *
     * @param \Backend\AdminBundle\Entity\Articulos $articulos
     * @return TipoArticulo
     */
    public function addArticulo(\Backend\AdminBundle\Entity\Articulo $articulos)
    {
        $this->articulos[] = $articulos;
    
        return $this;
    }

    /**
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
     * Add children
     *
     * @param \Backend\AdminBundle\Entity\TipoArticulo $children
     * @return TipoArticulo
     */
    public function addChildren(\Backend\AdminBundle\Entity\TipoArticulo $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Backend\AdminBundle\Entity\TipoArticulo $children
     */
    public function removeChildren(\Backend\AdminBundle\Entity\TipoArticulo $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Backend\AdminBundle\Entity\TipoArticulo $parent
     * @return TipoArticulo
     */
    public function setParent(\Backend\AdminBundle\Entity\TipoArticulo $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Backend\AdminBundle\Entity\TipoArticulo 
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    public function __toString()
	{
		return $this->name;
	}

    /**
     * Add ingresos
     *
     * @param \Backend\AdminBundle\Entity\Ingreso $ingresos
     * @return TipoArticulo
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
}