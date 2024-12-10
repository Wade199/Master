<?php

namespace App\Form;

use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'The name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'The name cannot be longer than {{ limit }} characters.',
                    ]),
                    new NotBlank([
                        'message' => 'This field cannot be blank.',
                    ]),
                ],
            ])
            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => '2',
                    'max' => '50',
                ],
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Positive([
                        'message' => 'The price must be positive.',
                    ]),
                    new LessThan([
                        'value' => 200,
                        'message' => 'The price must be less than {{ compared_value }}.',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'Créer mon ingrédient',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
