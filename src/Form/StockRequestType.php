<?php

namespace App\Form;

use App\Entity\Sites;
use App\Entity\StockRequest;
use App\Entity\User;
use App\Enum\Stock\StockRequestStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Draft' => 'draft',
                    'Pending HW Employee' => 'pending_hw_employee',
                    'Pending Manager' => 'pending_manager',
                    'Pending Admin' => 'pending_admin',
                    'Approved' => 'approved',
                    'Rejected' => 'rejected',
                ],
                'disabled' => !$options['is_admin'],
                'required' => false,
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ])
            ->add('fromSite', EntityType::class, [
                'class' => Sites::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ])
            ->add('toSite', EntityType::class, [
                'class' => Sites::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StockRequest::class,
            'csrf_token_id'   => 'stock_request_items_token',
            'isStockRequestReviewer' => false
        ]);
    }
}
