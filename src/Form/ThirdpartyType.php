<?php

namespace App\Form;

use App\Entity\Thirdparty;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThirdpartyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'class' => 'w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary',
                    'placeholder' => 'Nom',
                ],
                'label_attr' => [
                    'class' => 'mb-3 block text-sm font-medium text-black dark:text-white'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => array_flip(Thirdparty::THIRDPARTY_TYPES),
                'attr' => [
                    'class' => 'w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary',
                ],
                'label_attr' => [
                    'class' => 'mb-3 block text-sm font-medium text-black dark:text-white'
                ]
            ])
            /*->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])*/
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
            'data_class' => Thirdparty::class,
        ]);
    }
}
