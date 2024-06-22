<?php

namespace App\Entity;

use App\Repository\MonthlyBudgetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonthlyBudgetRepository::class)]
class MonthlyBudget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'monthlyBudgets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, PlannedTransaction>
     */
    #[ORM\OneToMany(targetEntity: PlannedTransaction::class, mappedBy: 'monthlyBudget', orphanRemoval: true)]
    private Collection $plannedTransactions;

    public function __construct()
    {
        $this->plannedTransactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, PlannedTransaction>
     */
    public function getPlannedTransactions(): Collection
    {
        return $this->plannedTransactions;
    }

    public function addPlannedTransaction(PlannedTransaction $plannedTransaction): static
    {
        if (!$this->plannedTransactions->contains($plannedTransaction)) {
            $this->plannedTransactions->add($plannedTransaction);
            $plannedTransaction->setMonthlyBudget($this);
        }

        return $this;
    }

    public function removePlannedTransaction(PlannedTransaction $plannedTransaction): static
    {
        if ($this->plannedTransactions->removeElement($plannedTransaction)) {
            // set the owning side to null (unless already changed)
            if ($plannedTransaction->getMonthlyBudget() === $this) {
                $plannedTransaction->setMonthlyBudget(null);
            }
        }

        return $this;
    }
}
