<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\MonthlyBudget;
use App\Entity\PlannedTransaction;
use App\Entity\Thirdparty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlannedTransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount')
            ->add('label')
            ->add('categorie', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
            ])
            ->add('monthlyBudget', EntityType::class, [
                'class' => MonthlyBudget::class,
                'choice_label' => 'id',
                'attr' => ['class' => 'hidden'],
                'label_attr' => ['class' => 'hidden'],
            ])
            ->add('thirdparty', EntityType::class, [
                'class' => Thirdparty::class,
                'choice_label' => 'id',
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
