<?php

namespace App\Form;

use App\Entity\Sites;
use App\Entity\StockRequest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fromSite', EntityType::class, [
                'class' => Sites::class,
                'choice_label' => 'name',
                'disabled' => !$options['editable'],
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ])
            ->add('toSite', EntityType::class, [
                'class' => Sites::class,
                'choice_label' => 'name',
                'disabled' => !$options['editable'],
                'attr' => [
                    'class' => 'select2-dropdown-single',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StockRequest::class,
            'csrf_token_id' => 'stock_request_items_token',
            'editable' => false
        ]);
    }
}
