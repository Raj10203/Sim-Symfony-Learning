<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\StockRequest;
use App\Entity\StockRequestItem;
use App\Enum\ActiveInventoryStatus;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockRequestItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var StockRequest|null $stockRequest */
        $stockRequest = $options['stock_request'] ?? null;

        $usedProducts = [];

        if ($stockRequest) {
            foreach ($stockRequest->getStockRequestItems() as $item) {
                $usedProducts[] = $item->getProduct();
            }
        }

        $builder
            ->add('quantity_requested', IntegerType::class, [
                'label' => 'Quantity',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('quantity_approved', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('status', EnumType::class, [
                'class' => ActiveInventoryStatus::class,
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ])
            ->add('stockRequest', EntityType::class, [
                'class' => StockRequest::class,
                'choice_label' => 'id',
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a product',
                'query_builder' => function (EntityRepository $er) use ($usedProducts) {
                    $qb = $er->createQueryBuilder('p');
                    if ($usedProducts) {
                        $qb->where('p NOT IN (:used)')
                            ->andWhere('p.active = TRUE')
                            ->setParameter('used', $usedProducts);
                    }
                    return $qb;
                },
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StockRequestItem::class,
            'stock_request' => null,
            'csrf_token_id' => 'stock_request_items',
        ]);
    }
}
