<?php

namespace cano\UEKCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classroom
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="cano\UEKCBundle\Entity\ClassroomRepository")
 */
class Classroom
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Classes", mappedBy="classroom")
     */
    protected $classes;

    /**
     * @ORM\ManyToOne(targetEntity="Building", inversedBy="classroom")
     * @ORM\JoinColumn(name="building_id", referencedColumnName="id")
     */
    protected $building;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Classroom
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
     * Add classes
     *
     * @param \cano\UEKCBundle\Entity\Classes $classes
     * @return Classroom
     */
    public function addClass(\cano\UEKCBundle\Entity\Classes $classes)
    {
        $this->classes[] = $classes;

        return $this;
    }

    /**
     * Remove classes
     *
     * @param \cano\UEKCBundle\Entity\Classes $classes
     */
    public function removeClass(\cano\UEKCBundle\Entity\Classes $classes)
    {
        $this->classes->removeElement($classes);
    }

    /**
     * Get classes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Set building
     *
     * @param \cano\UEKCBundle\Entity\Building $building
     * @return Classroom
     */
    public function setBuilding(\cano\UEKCBundle\Entity\Building $building = null)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * Get building
     *
     * @return \cano\UEKCBundle\Entity\Building 
     */
    public function getBuilding()
    {
        return $this->building;
    }
}
