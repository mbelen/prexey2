<?php

namespace Backend\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="articulo")
 * @ORM\Entity()
 */

class Articulo
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
     * @ORM\Column(name="is_disponible", type="boolean" )
     */
    private $isDisponible;
    
   /**
     * @ORM\ManyToOne(targetEntity="TipoArticulo", inversedBy="articulos")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
     */

    protected $tipo;    

     /**
     * @ORM\Column(name="imei", type="string", length=15, nullable=true)
     */
     
    private $imei;
    
     /**
     * @ORM\Column(name="serial", type="string", length=15, nullable=true)
     */ 
     
    private $serial;
    
    /**
     * @ORM\Column(name="is_gtia", type="boolean" )
     */ 
            
    private $garantia;
    
    /**
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */    
     
    private $descripcion;
    
    /**
     * @ORM\ManyToOne(targetEntity="Estado", inversedBy="articulos")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     */    
    
    protected $estado;
       
     /**
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    
    private $observacion;
        
    /**
     * @ORM\ManyToOne(targetEntity="Marca", inversedBy="articulos")
     * @ORM\JoinColumn(name="marca_id", referencedColumnName="id")
     */    

    protected $marca;
           
    /**
     * @ORM\ManyToOne(targetEntity="Modelo", inversedBy="articulos")
     * @ORM\JoinColumn(name="modelo_id", referencedColumnName="id")
     */ 
      
    protected $modelo;
	

	/**
	 * @ORM\ManyToMany(targetEntity="Movimiento", inversedBy="articulos")
     * @ORM\JoinTable(name="articulo_movimiento")
	 */	
		
	protected $movimientos;


		         
    /**
     * Constructor
     */

    public function __construct()
    {
         $this->isDelete=false;
         $this->isValido=true;
         $this->createdAt = new \DateTime('now');
         $this->movimientos = new ArrayCollection();   

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
     * @return Articulo
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
     * @return Articulo
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
     * Set isDisponible
     *
     * @param boolean $isDisponible
     * @return Articulo
     */
    public function setIsDisponible($isDisponible)
    {
        $this->isDisponible = $isDisponible;
    
        return $this;
    }

    /**
     * Get isDisponible
     *
     * @return boolean 
     */
    public function getIsDisponible()
    {
        return $this->isDisponible;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Articulo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Articulo
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;
    
        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set tipo
     *
     * @param \Backend\AdminBundle\Entity\TipoArticulo $tipo
     * @return Articulo
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
     * Add modelos
     *
     * @param \Backend\AdminBundle\Entity\Modelo $modelos
     * @return Articulo
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
     * Set marca
     *
     * @param \Backend\AdminBundle\Entity\Marca $marca
     * @return Articulo
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
     * @return Articulo
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
     * Set imei
     *
     * @param string $imei
     * @return Articulo
     */
    public function setImei($imei)
    {
        $this->imei = $imei;
    
        return $this;
    }

    /**
     * Get imei
     *
     * @return string 
     */
    public function getImei()
    {
        return $this->imei;
    }

    /**
     * Set serial
     *
     * @param string $serial
     * @return Articulo
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;
    
        return $this;
    }

    /**
     * Get serial
     *
     * @return string 
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set garantia
     *
     * @param boolean $garantia
     * @return Articulo
     */
    public function setGarantia($garantia)
    {
        $this->garantia = $garantia;
    
        return $this;
    }

    /**
     * Get garantia
     *
     * @return boolean 
     */
    public function getGarantia()
    {
        return $this->garantia;
    }

    /**
     * Set estado
     *
     * @param \Backend\AdminBundle\Entity\Estado $estado
     * @return Articulo
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
     * Add movimientos
     *
     * @param \Backend\AdminBundle\Entity\Movimiento $movimientos
     * @return Articulo
     */
    public function addMovimiento(\Backend\AdminBundle\Entity\Movimiento $movimientos)
    {
        $this->movimientos[] = $movimientos;
    
        return $this;
    }

    /**
     * Remove movimientos
     *
     * @param \Backend\AdminBundle\Entity\Movimiento $movimientos
     */
    public function removeMovimiento(\Backend\AdminBundle\Entity\Movimiento $movimientos)
    {
        $this->movimientos->removeElement($movimientos);
    }

    /**
     * Get movimientos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }
}