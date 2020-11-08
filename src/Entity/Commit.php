<?php

namespace App\Entity;

use App\Repository\CommitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommitRepository::class)
 */
class Commit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="date")
     */
    private $date_of_creation;

    /**
     * @ORM\ManyToOne(targetEntity=Blogpost::class, inversedBy="commits")
     */
    private $article;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDateOfCreation(): ?\DateTimeInterface
    {
        return $this->date_of_creation;
    }

    public function setDateOfCreation(\DateTimeInterface $date_of_creation): self
    {
        $this->date_of_creation = $date_of_creation;

        return $this;
    }

    public function getArticle(): ?Blogpost
    {
        return $this->article;
    }

    public function setArticle(?Blogpost $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }
}
