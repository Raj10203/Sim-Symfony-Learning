<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\RetiredInventory;
use App\Entity\Site;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetiredInventoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('retiredAt', null, [
                'widget' => 'single_text',
            ])
            ->add('status')
            ->add('retirementReason')
            ->add('serialNo')
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
            ->add('retiredBy', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RetiredInventory::class,
        ]);
    }
}
