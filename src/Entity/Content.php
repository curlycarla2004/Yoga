<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContentRepository")
 * @Vich\Uploadable
 * @ORM\Table(name="content")
 */
class Content
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $k;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $content_image;


    /**
     * @Vich\UploadableField(mapping="content_images", fileNameProperty="contentImage")
     * 
     * @var File
     */
    private $imageFile;

     /**
     * @var \DateTime 
     * @ORM\Column(type="datetime", options={"default" : "CURRENT_TIMESTAMP"})
     */
    private $updatedAt;
    
    /**
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;


    /**
     * 0 = text
     * 1 = image
     * 
     * @ORM\Column(type="smallint")
     */
    private $type;

    public function __construct()
    {
       
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getK(): ?string
    {
        return $this->k;
    }

    public function setK(string $k): self
    {
        $this->k = $k;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContentImage()
    {
        return $this->content_image;
    }

    public function setContentImage($content_image)
    {
        $this->content_image = $content_image;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
 
    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
 
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

 
}
