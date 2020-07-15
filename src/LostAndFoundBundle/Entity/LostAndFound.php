<?php

namespace LostAndFoundBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LostAndFound
 *
 * @ORM\Table(name="lost_and_found")
 * @ORM\Entity(repositoryClass="LostAndFoundBundle\Repository\LostAndFoundRepository")
 */
class LostAndFound
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="date" ,nullable=true)
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * One Product has One Shipment.
     * @ORM\OneToOne(targetEntity="LostAndFoundBundle\Entity\File",cascade={"persist","remove"})
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     */
    private $file;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return LostAndFound
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set date
     *
     * @param \DateTime $createdAt
     *
     * @return LostAndFound
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set image
     *
     * @param \LostAndFoundBundle\Entity\File $file
     *
     * @return LostAndFound
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get image
     *
     * @return \LostAndFoundBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }
}

