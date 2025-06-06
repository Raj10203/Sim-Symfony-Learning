<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\StockMovement;
use App\Entity\StockMovementItem;
use App\Entity\StockRequest;
use App\Enum\StockRequestItemsStatus;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockMovementItemForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var StockRequest|null $stockRequest */
        $stockRequest = $options['stockRequest'];

        $builder
            ->add('quantity',  NumberType::class, [
                'label' => 'Quantity',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('remarks',  TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) use ($stockRequest) {
                    return $er->createQueryBuilder('p')
                        ->innerJoin('p.stockRequestItems', 'sri') // adjust this relation if needed
                        ->where('sri.stockRequest = :stockRequest')
                        ->andWhere('sri.status = :status')
                        ->setParameter('stockRequest', $stockRequest)
                        ->setParameter('status', StockRequestItemsStatus::Approved);
                },
                'attr' => [
                    'class' => 'select2-dropdown-single',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StockMovementItem::class,
            'stockRequest' => null,
        ]);
    }
}
