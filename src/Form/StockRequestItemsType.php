<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\StockRequest;
use App\Entity\StockRequestItems;
use App\Enum\Stock\StockRequestStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockRequestItemsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity_requested', null, [
                'label' => 'Quantity',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('quantity_approved', null, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('status', EnumType::class, [
                'class' => StockRequestStatus::class,
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ])
            ->add('requestId', EntityType::class, [
                'class' => StockRequest::class,
                'choice_label' => 'id',
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ])
            ->add('productId', EntityType::class, [
                'class' => Products::class,
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
            'data_class' => StockRequestItems::class,
        ]);
    }
}
