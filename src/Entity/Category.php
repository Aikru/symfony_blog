<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=blogpost::class, inversedBy="categories")
     */
    private $blogpost;

    public function __construct()
    {
        $this->blogpost = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|blogpost[]
     */
    public function getBlogpost(): Collection
    {
        return $this->blogpost;
    }

    public function addBlogpost(blogpost $blogpost): self
    {
        if (!$this->blogpost->contains($blogpost)) {
            $this->blogpost[] = $blogpost;
        }

        return $this;
    }

    public function removeBlogpost(blogpost $blogpost): self
    {
        $this->blogpost->removeElement($blogpost);

        return $this;
    }
}
