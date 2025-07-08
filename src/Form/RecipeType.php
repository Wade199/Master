<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
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
            ->add('time', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 1440,
                ],
                'label' => 'Temps (en minutes)',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Positive([
                        'message' => 'The price must be positive.',
                    ]),
                    new LessThan([
                        'value' => 1441,
                        'message' => 'The price must be less than {{ compared_value }}.',
                    ]),
                ],
            ])
            ->add('nbPersonne', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 50,
                ],
                'label' => 'Nombre de personnes',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Positive([
                        'message' => 'The price must be positive.',
                    ]),
                    new LessThan([
                        'value' => 51,
                        'message' => 'The price must be less than {{ compared_value }}.',
                    ]),
                ],
            ])
            ->add('difficulte', RangeType::class, [
                'attr' => [
                    'class' => 'form-range',
                    'min' => 1,
                    'max' => 5,
                ],
                'label' => 'Difficulté',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Positive([
                        'message' => 'The price must be positive.',
                    ]),
                    new LessThan([
                        'value' => 5,
                        'message' => 'The price must be less than {{ compared_value }}.',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 5,
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'The price must be positive.',
                    ]),
                ],
            ])
            ->add('prix', MoneyType::class, [
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
                        'value' => 1001,
                        'message' => 'The price must be less than {{ compared_value }}.',
                    ]),
                ],
            ])
            ->add('favorite', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Favoris ?',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new NotNull([
                        'message' => 'The price must be positive.',
                    ]),
                ],
            ])
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])

            
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4',
                ],
                'label' => 'Submit',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
