<?php

namespace App\Controller;

use App\Entity\MonthlyBudget;
use App\Entity\PlannedTransaction;
use App\Form\PlannedTransactionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
#[Route('/budget')]
class BudgetController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'app_budget_index')]
    public function index(): Response
    {
        if ($this->getUser()->getMonthlyBudgets()->isEmpty()) {
            $budget = $this->createFirstBudget();
        } else {
            $budget = $this->getUser()->getMonthlyBudgets()->first();
        }

        return $this->render('budget/index.html.twig', [
            'transactions' => $budget->getPlannedTransactions()
        ]);
    }

    #[Route('/new', name: 'app_budget_transaction_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_budget_transaction_edit', methods: ['GET', 'POST'])]
    public function createOrEdit(Request $request, EntityManagerInterface $entityManager, ?PlannedTransaction $plannedTransaction): Response
    {
        $plannedTransaction = $plannedTransaction ?: new PlannedTransaction();
        $form = $this->createForm(PlannedTransactionType::class, $plannedTransaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plannedTransaction);
            $entityManager->flush();

            return $this->redirectToRoute('app_budget_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('budget/newtransaction.html.twig', [
            'planned_transaction' => $plannedTransaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_budget_transaction_delete', methods: ['POST'])]
    public function delete(Request $request, PlannedTransaction $plannedTransaction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plannedTransaction->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($plannedTransaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_budget_index', [], Response::HTTP_SEE_OTHER);
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
