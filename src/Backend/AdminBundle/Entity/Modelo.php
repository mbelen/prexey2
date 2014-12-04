<?php 
namespace Backend\AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="modelo")
 * @ORM\Entity()
 */
class Modelo
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(name="name", type="string", length=100)
     */
    public $name;
    /**
     * @ORM\Column(name="nameManufacture", type="string", length=100)
     */
    public $nameManufacture;
    /**
     * @ORM\Column(name="variante", type="string", length=100, nullable=true)
     */
    public $variante;
    
        /**
     * @ORM\Column(name="is_delete", type="boolean" )
     */
    private $isDelete;

    /**
     * @ORM\ManyToOne(targetEntity="Marca", inversedBy="modelos")
     * @ORM\JoinColumn(name="marca_id", referencedColumnName="id")
     */    
    public $marca;

	/**
     * @ORM\ManyToOne(targetEntity="Articulo", inversedBy="modelo")
     * 
     **/     
    private $articulos;

	    
   public function __construct()
    {
        $this->isDelete=false;
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
     * @return Modelo
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
     * Set nameManufacture
     *
     * @param string $nameManufacture
     * @return Modelo
     */
    public function setNameManufacture($nameManufacture)
    {
        $this->nameManufacture = $nameManufacture;
    
        return $this;
    }

    /**
     * Get nameManufacture
     *
     * @return string 
     */
    public function getNameManufacture()
    {
        return $this->nameManufacture;
    }

    /**
     * Set variante
     *
     * @param string $variante
     * @return Modelo
     */
    public function setVariante($variante)
    {
        $this->variante = $variante;
    
        return $this;
    }

    /**
     * Get variante
     *
     * @return string 
     */
    public function getVariante()
    {
        return $this->variante;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     * @return Modelo
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
     * Set marca
     *
     * @param \Backend\AdminBundle\Entity\Marca $marca
     * @return Modelo
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
     * Add articulos
     *
     * @param \Backend\AdminBundle\Entity\Articulo $articulos
     * @return Modelo
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
     * Set articulos
     *
     * @param \Backend\AdminBundle\Entity\Articulo $articulos
     * @return Modelo
     */
    public function setArticulos(\Backend\AdminBundle\Entity\Articulo $articulos = null)
    {
        $this->articulos = $articulos;
    
        return $this;
    }
}