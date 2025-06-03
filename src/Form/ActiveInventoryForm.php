<?php

namespace App\Form;

use App\Entity\ActiveInventory;
use App\Entity\Product;
use App\Entity\Site;
use App\Entity\StockMovement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiveInventoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('serialNo')
            ->add('receivedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('remarks')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'id',
            ])
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'id',
            ])
            ->add('lastStockMovement', EntityType::class, [
                'class' => StockMovement::class,
                'choice_label' => 'id',
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
