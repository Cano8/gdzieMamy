<?php

namespace cano\UEKCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="cano\UEKCBundle\Entity\TeacherRepository")
 */
class Teacher
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
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="mew_address", type="string", length=255)
     */
    private $mewAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_address", type="string", length=255)
     */
    private $photoAddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @ORM\ManyToMany(targetEntity="Classes", mappedBy="teacher")
     */
    protected $classes;

    /**
     * @ORM\ManyToOne(targetEntity="Degrees", inversedBy="teacher")
     * @ORM\JoinColumn(name="degree_id", referencedColumnName="id")
     */
    protected $degree;
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
     * @return Teacher
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
     * Set lastname
     *
     * @param string $lastname
     * @return Teacher
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set mewAddress
     *
     * @param string $mewAddress
     * @return Teacher
     */
    public function setMewAddress($mewAddress)
    {
        $this->mewAddress = $mewAddress;

        return $this;
    }

    /**
     * Get mewAddress
     *
     * @return string 
     */
    public function getMewAddress()
    {
        return $this->mewAddress;
    }

    /**
     * Set photoAddress
     *
     * @param string $photoAddress
     * @return Teacher
     */
    public function setPhotoAddress($photoAddress)
    {
        $this->photoAddress = $photoAddress;

        return $this;
    }

    /**
     * Get photoAddress
     *
     * @return string 
     */
    public function getPhotoAddress()
    {
        return $this->photoAddress;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     * @return Teacher
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Add classes
     *
     * @param \cano\UEKCBundle\Entity\Classes $classes
     * @return Teacher
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
     * Set degree
     *
     * @param \cano\UEKCBundle\Entity\Degrees $degree
     * @return Teacher
     */
    public function setDegree(\cano\UEKCBundle\Entity\Degrees $degree = null)
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * Get degree
     *
     * @return \cano\UEKCBundle\Entity\Degrees 
     */
    public function getDegree()
    {
        return $this->degree;
    }
}
