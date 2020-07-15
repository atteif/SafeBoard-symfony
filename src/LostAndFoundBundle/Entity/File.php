<?php

namespace LostAndFoundBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="LostAndFoundBundle\Repository\FileRepository")
 */
class File
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
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at",type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var string
     * @Assert\Image()
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    public function getUploadRootDir()
    {
        return __dir__.'/../../../web/uploads';
    }


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
     * Set image
     *
     * @param string $image
     *
     * @return File
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Post
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
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
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }
}