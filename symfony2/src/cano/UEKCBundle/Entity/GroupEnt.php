<?php

namespace cano\UEKCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupEnt
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="cano\UEKCBundle\Entity\GroupEntRepository")
 */
class GroupEnt
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
     * @ORM\ManyToMany(targetEntity="Classes", mappedBy="group")
     */
    protected $classes;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="groups")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    protected $course;
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
     * @return GroupEnt
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
     * @return GroupEnt
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
     * Set course
     *
     * @param \cano\UEKCBundle\Entity\Course $course
     * @return GroupEnt
     */
    public function setCourse(\cano\UEKCBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \cano\UEKCBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }
}
