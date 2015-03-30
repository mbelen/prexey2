<?php

namespace Backend\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="deposito")
 * @ORM\Entity() 
 */
class Deposito
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
     * @ORM\Column(name="created_at", type="datetime")
     */
    
    private $createdAt;

    /**
     * @ORM\Column(name="modified_at", type="datetime")
     */
    
    private $modifiedAt;

     /**
     * @ORM\ManyToOne(targetEntity="TipoDeposito", inversedBy="depositos")
     * @ORM\JoinColumn(name="tipodeposito_id", referencedColumnName="id")
     */
    private $tipoDeposito;
    
     /**
     * @ORM\ManyToOne(targetEntity="AreaTrabajo", inversedBy="depositos")
     * @ORM\JoinColumn(name="area_id", referencedColumnName="id")
     */
     
    private $area; 
    
    
    /**
     * @ORM\OneToMany(targetEntity="Movimiento", mappedBy="depositoDestino")
     */

    protected $movimientosDestino;   
    
    /**
     * @ORM\OneToMany(targetEntity="Movimiento", mappedBy="depositoOrigen")
     */

    protected $movimientosOrigen; 
            
    /**
     * @ORM\OneToMany(targetEntity="MovimientoParte", mappedBy="depositoOrigen")
     */

    protected $movimientosPartesOrigen;
    
	/**
     * @ORM\OneToMany(targetEntity="MovimientoParte", mappedBy="depositoDestino")
     */

    protected $movimientosPartesDestino;
 
        
    /**
     * @ORM\OneToMany(targetEntity="OrdenIngreso", mappedBy="deposito")
     */

    protected $ordenesIngreso;  
    
     /**
     * @ORM\OneToMany(targetEntity="OrdenIngresoParte", mappedBy="deposito")
     */

    protected $ordenesIngresoParte;          
    
    
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
     * @return Deposito
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
     * @return Deposito
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Deposito
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
     * @return Deposito
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
     * Set tipoDeposito
     *
     * @param \Backend\AdminBundle\Entity\TipoDeposito $tipoDeposito
     * @return Deposito
     */
    public function setTipoDeposito(\Backend\AdminBundle\Entity\TipoDeposito $tipoDeposito = null)
    {
        $this->tipoDeposito = $tipoDeposito;
    
        return $this;
    }

    /**
     * Get tipoDeposito
     *
     * @return \Backend\AdminBundle\Entity\TipoDeposito 
     */
    public function getTipoDeposito()
    {
        return $this->tipoDeposito;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movimientos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add movimientos
     *
     * @param \Backend\AdminBundle\Entity\Movimiento $movimientos
     * @return Deposito
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

    /**
     * Add ordenesIngreso
     *
     * @param \Backend\AdminBundle\Entity\OrdenIngreso $ordenesIngreso
     * @return Deposito
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
     * Set area
     *
     * @param \Backend\AdminBundle\Entity\AreaTrabajo $area
     * @return Deposito
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
     * Add movimientosPartes
     *
     * @param \Backend\AdminBundle\Entity\MovimientoParte $movimientosPartes
     * @return Deposito
     */
    public function addMovimientosParte(\Backend\AdminBundle\Entity\MovimientoParte $movimientosPartes)
    {
        $this->movimientosPartes[] = $movimientosPartes;
    
        return $this;
    }

    /**
     * Remove movimientosPartes
     *
     * @param \Backend\AdminBundle\Entity\MovimientoParte $movimientosPartes
     */
    public function removeMovimientosParte(\Backend\AdminBundle\Entity\MovimientoParte $movimientosPartes)
    {
        $this->movimientosPartes->removeElement($movimientosPartes);
    }

    /**
     * Get movimientosPartes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovimientosPartes()
    {
        return $this->movimientosPartes;
    }

    /**
     * Add movimientosDestino
     *
     * @param \Backend\AdminBundle\Entity\Movimiento $movimientosDestino
     * @return Deposito
     */
    public function addMovimientosDestino(\Backend\AdminBundle\Entity\Movimiento $movimientosDestino)
    {
        $this->movimientosDestino[] = $movimientosDestino;
    
        return $this;
    }

    /**
     * Remove movimientosDestino
     *
     * @param \Backend\AdminBundle\Entity\Movimiento $movimientosDestino
     */
    public function removeMovimientosDestino(\Backend\AdminBundle\Entity\Movimiento $movimientosDestino)
    {
        $this->movimientosDestino->removeElement($movimientosDestino);
    }

    /**
     * Get movimientosDestino
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovimientosDestino()
    {
        return $this->movimientosDestino;
    }

    /**
     * Add movimientosOrigen
     *
     * @param \Backend\AdminBundle\Entity\Movimiento $movimientosOrigen
     * @return Deposito
     */
    public function addMovimientosOrigen(\Backend\AdminBundle\Entity\Movimiento $movimientosOrigen)
    {
        $this->movimientosOrigen[] = $movimientosOrigen;
    
        return $this;
    }

    /**
     * Remove movimientosOrigen
     *
     * @param \Backend\AdminBundle\Entity\Movimiento $movimientosOrigen
     */
    public function removeMovimientosOrigen(\Backend\AdminBundle\Entity\Movimiento $movimientosOrigen)
    {
        $this->movimientosOrigen->removeElement($movimientosOrigen);
    }

    /**
     * Get movimientosOrigen
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovimientosOrigen()
    {
        return $this->movimientosOrigen;
    }

    /**
     * Add movimientosPartesOrigen
     *
     * @param \Backend\AdminBundle\Entity\MovimientoParte $movimientosPartesOrigen
     * @return Deposito
     */
    public function addMovimientosPartesOrigen(\Backend\AdminBundle\Entity\MovimientoParte $movimientosPartesOrigen)
    {
        $this->movimientosPartesOrigen[] = $movimientosPartesOrigen;
    
        return $this;
    }

    /**
     * Remove movimientosPartesOrigen
     *
     * @param \Backend\AdminBundle\Entity\MovimientoParte $movimientosPartesOrigen
     */
    public function removeMovimientosPartesOrigen(\Backend\AdminBundle\Entity\MovimientoParte $movimientosPartesOrigen)
    {
        $this->movimientosPartesOrigen->removeElement($movimientosPartesOrigen);
    }

    /**
     * Get movimientosPartesOrigen
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovimientosPartesOrigen()
    {
        return $this->movimientosPartesOrigen;
    }

    /**
     * Add movimientosPartesDestino
     *
     * @param \Backend\AdminBundle\Entity\MovimientoParte $movimientosPartesDestino
     * @return Deposito
     */
    public function addMovimientosPartesDestino(\Backend\AdminBundle\Entity\MovimientoParte $movimientosPartesDestino)
    {
        $this->movimientosPartesDestino[] = $movimientosPartesDestino;
    
        return $this;
    }

    /**
     * Remove movimientosPartesDestino
     *
     * @param \Backend\AdminBundle\Entity\MovimientoParte $movimientosPartesDestino
     */
    public function removeMovimientosPartesDestino(\Backend\AdminBundle\Entity\MovimientoParte $movimientosPartesDestino)
    {
        $this->movimientosPartesDestino->removeElement($movimientosPartesDestino);
    }

    /**
     * Get movimientosPartesDestino
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovimientosPartesDestino()
    {
        return $this->movimientosPartesDestino;
    }

    /**
     * Add ordenesIngresoParte
     *
     * @param \Backend\AdminBundle\Entity\OrdenIngresoParte $ordenesIngresoParte
     * @return Deposito
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