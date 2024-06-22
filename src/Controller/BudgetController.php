<?php

namespace App\Controller;

use App\Entity\MonthlyBudget;
use App\Form\BudgetFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class BudgetController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/budget', name: 'app_budget')]
    public function index(): Response
    {
        if ($this->getUser()->getMonthlyBudgets()->isEmpty()) {
            $budget = $this->createFirstBudget();
        } else {
            $budget = $this->getUser()->getMonthlyBudgets()->first();
        }

        $form = $this->createForm(BudgetFormType::class, $budget);

        return $this->render('budget/index.html.twig', [
            'form' => $form,
        ]);
    }

    private function createFirstBudget()
    {
        $user = $this->getUser();

        $budget = new MonthlyBudget();
        $budget->setUser($user);

        $this->entityManager->persist($budget);
        $this->entityManager->flush();

        return $budget;
    }
}
