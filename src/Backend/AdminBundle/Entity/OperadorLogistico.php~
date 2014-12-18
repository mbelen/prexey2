<?php 
namespace Backend\AdminBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="operador_logistico")
 * @ORM\Entity()
 */
class OperadorLogistico
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
     * @ORM\Column(name="cuit", type="string", length=100, nullable=true)
     */
    private $cuit;
    
    /**
     * @ORM\Column(name="dni", type="string", length=100, nullable=true)
     */
    private $dni;
    
    /**
     * @ORM\Column(name="codigo", type="string", length=100)
     */
    private $codigo;

    /**
     * @ORM\Column(name="direccion", type="text", nullable=true)
     */
    private $direccion;
    /**
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    private $observacion;
    
     /**
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;
     /**
     * @ORM\Column(name="celular", type="string", length=100, nullable=true)
     */
    private $celular;
    
    /**
     * @ORM\Column(name="is_delete", type="boolean" )
     */
    private $isDelete;      
       
    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
    /**
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     */
    private $modifiedAt; 
    
     /**
     * @ORM\OneToMany(targetEntity="OrdenIngreso", mappedBy="operador")
     */
    protected $ordenesIngreso;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        
        $this->isDelete=false;
        $this->createdAt = new \DateTime('now');
       
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
     * @return OperadorLogistico
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
        return mb_convert_case($this->name, MB_CASE_TITLE,"UTF-8");
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return OperadorLogistico
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    
        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return OperadorLogistico
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
     * Set email
     *
     * @param string $email
     * @return OperadorLogistico
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
     * Set celular
     *
     * @param string $celular
     * @return OperadorLogistico
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    
        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    
    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     * @return OperadorLogistico
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
     * Set cuit
     *
     * @param string $cuit
     * @return OperadorLogistico
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;
    
        return $this;
    }

    /**
     * Get cuit
     *
     * @return string 
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * @ORM\PreUpdate()
     * 
     */
     
    public function modifiedUpdate(){
    
      $this->setModifiedAt(new \DateTime('now'));
    }  
    

    /**
     * Set dni
     *
     * @param string $dni
     * @return OperadorLogistico
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    
        return $this;
    }

    /**
     * Get dni
     *
     * @return string 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return OperadorLogistico
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return OperadorLogistico
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
     * @return OperadorLogistico
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
     * Add ordenesIngreso
     *
     * @param \Backend\AdminBundle\Entity\OrdenIngreso $ordenesIngreso
     * @return OperadorLogistico
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
}