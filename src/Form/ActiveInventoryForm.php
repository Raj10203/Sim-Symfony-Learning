<?php

namespace App\Form;

use App\Entity\ActiveInventory;
use App\Entity\Product;
use App\Entity\Site;
use App\Entity\StockMovement;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiveInventoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('serialNo', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('remarks', TextareaType::class, [
                'label' => 'Remarks',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
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
            ->add('lastStockMovement', EntityType::class, [
                'class' => StockMovement::class,
                'choice_label' => 'id',
                'required' => false,
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActiveInventory::class,
        ]);
    }
}
