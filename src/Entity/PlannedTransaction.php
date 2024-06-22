<?php

namespace App\Entity;

use App\Repository\PlannedTransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlannedTransactionRepository::class)]
class PlannedTransaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'monthlyBudget')]
    private ?Category $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'plannedTransactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MonthlyBudget $monthlyBudget = null;

    #[ORM\ManyToOne]
    private ?Thirdparty $thirdparty = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getCategorie(): ?Category
    {
        return $this->categorie;
    }

    public function setCategorie(?Category $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getMonthlyBudget(): ?MonthlyBudget
    {
        return $this->monthlyBudget;
    }

    public function setMonthlyBudget(?MonthlyBudget $monthlyBudget): static
    {
        $this->monthlyBudget = $monthlyBudget;

        return $this;
    }

    public function getThirdparty(): ?Thirdparty
    {
        return $this->thirdparty;
    }

    public function setThirdparty(?Thirdparty $thirdparty): static
    {
        $this->thirdparty = $thirdparty;

        return $this;
    }
}
