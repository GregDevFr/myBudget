<?php

namespace App\Form;

use App\Entity\MonthlyBudget;
use App\Entity\PlannedTransaction;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BudgetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $budget = $builder->getData();

        $builder
            ->add('plannedTransactions', CollectionType::class, [
                'required' => false,
                'entry_type' => PlannedTransactionType::class,
                'entry_options' => [
                    'label' => false,
                    'monthlyBudget' => $budget->getId(),
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MonthlyBudget::class,
        ]);
    }
}
