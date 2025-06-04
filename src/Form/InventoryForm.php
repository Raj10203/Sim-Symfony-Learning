<?php

namespace App\Form;

use App\Entity\Inventory;
use App\Entity\Product;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inventory::class,
        ]);
    }
}
