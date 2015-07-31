<?php

namespace cano\UEKCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classes
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Classes
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startTime", type="time")
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endTime", type="time")
     */
    private $endTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="subject_id", type="integer")
     */
    private $subjectId;

    /**
     * @var integer
     *
     * @ORM\Column(name="classroom_id", type="integer")
     */
    private $classroomId;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="string", length=255)
     */
    private $notes;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=64)
     */
    private $hash;

    /**
     * @ORM\ManyToMany(targetEntity="Teacher", inversedBy="classes")
     * @ORM\JoinTable(name="classes_teachers")
     */
    protected $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="Classroom", inversedBy="classes")
     * @ORM\JoinColumn(name="classroom_id", referencedColumnName="id")
     */
    protected $classroom;

    /**
     * @ORM\ManyToMany(targetEntity="GroupEnt", inversedBy="classes")
     * @ORM\JoinTable(name="classes_groups")
     */
    protected $group;

    /**
     * @ORM\ManyToOne(targetEntity="Subject", inversedBy="classes")
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     */
    protected $subject;

    /**
     * @ORM\ManyToOne(targetEntity="Flags", inversedBy="classes")
     * @ORM\JoinColumn(name="flag_id", referencedColumnName="id")
     */
    protected $flags;

    /**
     * @ORM\ManyToOne(targetEntity="ClassType", inversedBy="classes")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $types;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teacher = new \Doctrine\Common\Collections\ArrayCollection();
        $this->group = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     * @return Classes
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return Classes
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return Classes
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set subjectId
     *
     * @param integer $subjectId
     * @return Classes
     */
    public function setSubjectId($subjectId)
    {
        $this->subjectId = $subjectId;

        return $this;
    }

    /**
     * Get subjectId
     *
     * @return integer 
     */
    public function getSubjectId()
    {
        return $this->subjectId;
    }

    /**
     * Set classroomId
     *
     * @param integer $classroomId
     * @return Classes
     */
    public function setClassroomId($classroomId)
    {
        $this->classroomId = $classroomId;

        return $this;
    }

    /**
     * Get classroomId
     *
     * @return integer 
     */
    public function getClassroomId()
    {
        return $this->classroomId;
    }

    /**
     * Set hash
     *
     * @param string $hash
     * @return Classes
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Add teacher
     *
     * @param \cano\UEKCBundle\Entity\Teacher $teacher
     * @return Classes
     */
    public function addTeacher(\cano\UEKCBundle\Entity\Teacher $teacher)
    {
        $this->teacher[] = $teacher;

        return $this;
    }

    /**
     * Remove teacher
     *
     * @param \cano\UEKCBundle\Entity\Teacher $teacher
     */
    public function removeTeacher(\cano\UEKCBundle\Entity\Teacher $teacher)
    {
        $this->teacher->removeElement($teacher);
    }

    /**
     * Get teacher
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set classroom
     *
     * @param \cano\UEKCBundle\Entity\Classroom $classroom
     * @return Classes
     */
    public function setClassroom(\cano\UEKCBundle\Entity\Classroom $classroom = null)
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * Get classroom
     *
     * @return \cano\UEKCBundle\Entity\Classroom 
     */
    public function getClassroom()
    {
        return $this->classroom;
    }

    /**
     * Add group
     *
     * @param \cano\UEKCBundle\Entity\GroupEnt $group
     * @return Classes
     */
    public function addGroup(\cano\UEKCBundle\Entity\GroupEnt $group)
    {
        $this->group[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \cano\UEKCBundle\Entity\GroupEnt $group
     */
    public function removeGroup(\cano\UEKCBundle\Entity\GroupEnt $group)
    {
        $this->group->removeElement($group);
    }

    /**
     * Get group
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set subject
     *
     * @param \cano\UEKCBundle\Entity\Subject $subject
     * @return Classes
     */
    public function setSubject(\cano\UEKCBundle\Entity\Subject $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \cano\UEKCBundle\Entity\Subject 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set flags
     *
     * @param \cano\UEKCBundle\Entity\Flags $flags
     * @return Classes
     */
    public function setFlags(\cano\UEKCBundle\Entity\Flags $flags = null)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Get flags
     *
     * @return \cano\UEKCBundle\Entity\Flags 
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Set types
     *
     * @param \cano\UEKCBundle\Entity\ClassType $types
     * @return Classes
     */
    public function setTypes(\cano\UEKCBundle\Entity\ClassType $types = null)
    {
        $this->types = $types;

        return $this;
    }

    /**
     * Get types
     *
     * @return \cano\UEKCBundle\Entity\ClassType 
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Classes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
