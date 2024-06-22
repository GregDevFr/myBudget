<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Self_;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    private const CATEGORY_DEBIT_TYPE = 0;
    private const CATEGORY_CREDIT_TYPE = 1;
    public const TYPES = [
        self::CATEGORY_DEBIT_TYPE => 'dépense',
        self::CATEGORY_CREDIT_TYPE => 'revenu'
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private int $type = 0;

    #[ORM\ManyToOne(inversedBy: 'categories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, PlannedTransaction>
     */
    #[ORM\OneToMany(targetEntity: PlannedTransaction::class, mappedBy: 'categorie')]
    private Collection $plannedTransactions;

    public function __construct()
    {
        $this->plannedTransactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): static
    {
        $this->type = $type;

        return $this;
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

    public function addPlannedTransactions(PlannedTransaction $plannedTransactions): static
    {
        if (!$this->plannedTransactions->contains($plannedTransactions)) {
            $this->plannedTransactions->add($plannedTransactions);
            $plannedTransactions->setCategorie($this);
        }

        return $this;
    }

    public function removePlannedTransactions(PlannedTransaction $plannedTransactions): static
    {
        if ($this->plannedTransactions->removeElement($plannedTransactions)) {
            // set the owning side to null (unless already changed)
            if ($plannedTransactions->getCategorie() === $this) {
                $plannedTransactions->setCategorie(null);
            }
        }

        return $this;
    }
}
