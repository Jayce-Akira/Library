<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgCover = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePublished = null;

    #[ORM\Column(length: 255)]
    private ?string $editor = null;

    #[ORM\Column]
    private ?int $nbOfBooks = null;

    #[ORM\ManyToMany(targetEntity: BookLoan::class, mappedBy: 'book')]
    private Collection $bookLoans;

    #[ORM\ManyToMany(targetEntity: type::class, inversedBy: 'books')]
    private Collection $type;

    public function __construct()
    {
        $this->bookLoans = new ArrayCollection();
        $this->type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImgCover(): ?string
    {
        return $this->imgCover;
    }

    public function setImgCover(?string $imgCover): self
    {
        $this->imgCover = $imgCover;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDatePublished(): ?\DateTimeInterface
    {
        return $this->datePublished;
    }

    public function setDatePublished(\DateTimeInterface $datePublished): self
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(string $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getNbOfBooks(): ?int
    {
        return $this->nbOfBooks;
    }

    public function setNbOfBooks(int $nbOfBooks): self
    {
        $this->nbOfBooks = $nbOfBooks;

        return $this;
    }

    /**
     * @return Collection<int, BookLoan>
     */
    public function getBookLoans(): Collection
    {
        return $this->bookLoans;
    }

    public function addBookLoan(BookLoan $bookLoan): self
    {
        if (!$this->bookLoans->contains($bookLoan)) {
            $this->bookLoans[] = $bookLoan;
            $bookLoan->addBook($this);
        }

        return $this;
    }

    public function removeBookLoan(BookLoan $bookLoan): self
    {
        if ($this->bookLoans->removeElement($bookLoan)) {
            $bookLoan->removeBook($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, type>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(type $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
        }

        return $this;
    }

    public function removeType(type $type): self
    {
        $this->type->removeElement($type);

        return $this;
    }
}
