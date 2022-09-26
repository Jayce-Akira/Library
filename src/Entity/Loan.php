<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoanRepository::class)]
class Loan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_reserved = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_loan = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_return = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column]
    private ?bool $is_late = null;

    #[ORM\ManyToOne(inversedBy: 'loans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    #[ORM\ManyToOne(inversedBy: 'loans')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;

    public function __construct()
    {
        $this->date_reserved = new \DateTimeImmutable();
        $this->is_late = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateReserved(): ?\DateTimeInterface
    {
        return $this->date_reserved;
    }

    public function setDateReserved(\DateTimeInterface $date_reserved): self
    {
        $this->date_reserved = $date_reserved;

        return $this;
    }

    public function getDateLoan(): ?\DateTimeInterface
    {
        return $this->date_loan;
    }

    public function setDateLoan(\DateTimeInterface $date_loan): self
    {
        $this->date_loan = $date_loan;

        return $this;
    }

    public function getDateReturn(): ?\DateTimeInterface
    {
        return $this->date_return;
    }

    public function setDateReturn(\DateTimeInterface $date_return): self
    {
        $this->date_return = $date_return;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIsLate(): ?bool
    {
        return $this->is_late;
    }

    public function setIsLate(bool $is_late): self
    {
        $this->is_late = $is_late;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function date_reserved(){
        return $this->date_reserved;
    }

    public function date_loan(){
        return $this->date_loan;
    }

    public function date_return(){
        return $this->date_return;
    }
    
    public function is_late(){
        return $this->is_late;
    }

}
