<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class CategoryController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    #[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        $user = $this->getUser();
        $categories = $this->entityManager->getRepository(Category::class)->findBy(['user' => $user]);

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/add', name: 'app_category_add')]
    #[Route('/category/{category}', name: 'app_category_edit', requirements: ['category' => '\d+'])]
    public function createOrEdit(
        Request $request,
        ?Category $category
    ): response
    {
        $category = $category ?: new Category();
        $user = $this->getUser();

        if ($category->getid() && $category->getUser()->getId() !== $user->getId()) {
            return $this->redirectToRoute('app_category');
        }

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                if (! $category->getUser()) $category->setUser($user);

                $this->entityManager->persist($category);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_category');

            } catch (\Exception $e) {
                dd($e->getMessage());
            }
        }

        return $this->render('category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);

    }

    #[Route('/category/delete/{category}', name: 'app_category_delete', requirements: ['category' => '\d+'])]
    public function delete(Category $category): Response
    {
        $user = $this->getUser();
        if ($category->getUser()->getId() !== $user->getId()) {
            return $this->redirectToRoute('app_category');
        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_category');
    }
}
