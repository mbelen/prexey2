<?php 
namespace Backend\AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="marca")
 * @ORM\Entity()
 */
class Marca
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=100)
     */
    protected $name;
    
        /**
     * @ORM\Column(name="is_delete", type="boolean" )
     */
    private $isDelete;
    
    /**
     * @ORM\OneToMany(targetEntity="Modelo", mappedBy="marca")
     */
    protected $modelos;
    
    /**
     * @ORM\OneToMany(targetEntity="Articulo", mappedBy="marca")
     */
    protected $articulos;
      
    
     
     
    
    public function __construct()
    {
        $this->isDelete=false;
        $this->modelos =  new ArrayCollection();
        $this->articulos = new ArrayCollection();
       
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
     * Set name
     *
     * @param string $name
     * @return Marca
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
     * @return Marca
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
     * Add modelos
     *
     * @param \Backend\AdminBundle\Entity\Modelo $modelos
     * @return Marca
     */
    public function addModelo(\Backend\AdminBundle\Entity\Modelo $modelos)
    {
        $this->modelos[] = $modelos;
    
        return $this;
    }

    /**
     * Remove modelos
     *
     * @param \Backend\AdminBundle\Entity\Modelo $modelos
     */
    public function removeModelo(\Backend\AdminBundle\Entity\Modelo $modelos)
    {
        $this->modelos->removeElement($modelos);
    }

    /**
     * Get modelos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getModelos()
    {
        return $this->modelos;
    }

    /**
     * Add articulos
     *
     * @param \Backend\AdminBundle\Entity\Articulo $articulos
     * @return Marca
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
     * Add sucursals
     *
     * @param \Backend\AdminBundle\Entity\Sucursal $sucursals
     * @return Marca
     */
    public function addSucursal(\Backend\AdminBundle\Entity\Sucursal $sucursals)
    {
        $this->sucursals[] = $sucursals;
    
        return $this;
    }

    /**
     * Remove sucursals
     *
     * @param \Backend\AdminBundle\Entity\Sucursal $sucursals
     */
    public function removeSucursal(\Backend\AdminBundle\Entity\Sucursal $sucursals)
    {
        $this->sucursals->removeElement($sucursals);
    }

    /**
     * Get sucursals
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSucursals()
    {
        return $this->sucursals;
    }
}