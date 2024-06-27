<?php

namespace App\Controller;

use App\Entity\Thirdparty;
use App\Form\ThirdpartyType;
use App\Repository\ThirdpartyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/thirdparty')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class ThirdpartyController extends AbstractController
{
    #[Route('/', name: 'app_thirdparty_index', methods: ['GET'])]
    public function index(ThirdpartyRepository $thirdpartyRepository): Response
    {
        return $this->render('thirdparty/index.html.twig', [
            'thirdparties' => $thirdpartyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_thirdparty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $thirdparty = new Thirdparty();
        $form = $this->createForm(ThirdpartyType::class, $thirdparty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($thirdparty);
            $entityManager->flush();

            return $this->redirectToRoute('app_thirdparty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('thirdparty/new.html.twig', [
            'thirdparty' => $thirdparty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_thirdparty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Thirdparty $thirdparty, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ThirdpartyType::class, $thirdparty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_thirdparty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('thirdparty/edit.html.twig', [
            'thirdparty' => $thirdparty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_thirdparty_delete', methods: ['POST'])]
    public function delete(Request $request, Thirdparty $thirdparty, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$thirdparty->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($thirdparty);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_thirdparty_index', [], Response::HTTP_SEE_OTHER);
    }
}
