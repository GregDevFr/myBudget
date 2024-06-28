<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\MonthlyBudget;
use App\Entity\PlannedTransaction;
use App\Entity\Thirdparty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlannedTransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', NumberType::class, [
                'label' => 'Montant',
                'attr' => [
                    'class' => 'w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary',
                    'placeholder' => 'Montant',
                ],
                'label_attr' => [
                    'class' => 'mb-3 block text-sm font-medium text-black dark:text-white'
                ]
            ])
            ->add('label', TextType::class, [
                'label' => 'Libellé',
                'attr' => [
                    'class' => 'w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary',
                    'placeholder' => 'Libellé',
                ],
                'label_attr' => [
                    'class' => 'mb-3 block text-sm font-medium text-black dark:text-white'
                ]
            ])
            ->add('categorie', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function (Category $category) {
                    return Category::TYPES[$category->getType()].' - '.$category->getName();
                },
                'attr' => [
                    'class' => 'w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary',
                    'placeholder' => 'Libellé',
                ],
                'label_attr' => [
                    'class' => 'mb-3 block text-sm font-medium text-black dark:text-white'
                ]
            ])
            ->add('monthlyBudget', EntityType::class, [
                'class' => MonthlyBudget::class,
                'choice_label' => 'id',
                'attr' => ['class' => 'hidden'],
                'label_attr' => ['class' => 'hidden'],
            ])
            ->add('thirdparty', EntityType::class, [
                'class' => Thirdparty::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary',
                    'placeholder' => 'Libellé',
                ],
                'label_attr' => [
                    'class' => 'mb-3 block text-sm font-medium text-black dark:text-white'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'flex w-full justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlannedTransaction::class,
            'monthlyBudget' => null,
        ]);
    }
}
