<?php

namespace cano\UEKCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CrawlStatus
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="cano\UEKCBundle\Entity\CrawlStatusRepository")
 */
class CrawlStatus
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
     * @ORM\Column(name="buildingName", type="string", length=255)
     */
    private $buildingName;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastCrawlDate", type="datetime")
     */
    private $lastCrawlDate;


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
     * Set buildingName
     *
     * @param string $buildingName
     * @return CrawlStatus
     */
    public function setBuildingName($buildingName)
    {
        $this->buildingName = $buildingName;

        return $this;
    }

    /**
     * Get buildingName
     *
     * @return string 
     */
    public function getBuildingName()
    {
        return $this->buildingName;
    }

    /**
     * Set lastCrawlDate
     *
     * @param \DateTime $lastCrawlDate
     * @return CrawlStatus
     */
    public function setLastCrawlDate($lastCrawlDate)
    {
        $this->lastCrawlDate = $lastCrawlDate;

        return $this;
    }

    /**
     * Get lastCrawlDate
     *
     * @return \DateTime 
     */
    public function getLastCrawlDate()
    {
        return $this->lastCrawlDate;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return CrawlStatus
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
