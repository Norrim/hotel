<?php
namespace AdminBundle\Entity;

use AdminBundle\Entity\Traits\TranslatableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="parameter_translations")
 */
class ParameterTranslation
{
    use TranslatableEntity;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Parameter", inversedBy="translations")
     * @ORM\JoinColumn(name="parameter_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $parameter;

    /**
     * @return Parameter
     */
    public function getParameter()
    {
        return $this->parameter;
    }

    /**
     * @param Parameter $parameter
     */
    public function setParameter(Parameter $parameter)
    {
        $this->parameter = $parameter;
    }
}
