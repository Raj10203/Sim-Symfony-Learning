<?php

namespace App\Factory;

use App\Entity\Product;
use App\Entity\Site;
use App\Messenger\Message\AddProductMessage;
use App\Messenger\Message\AddSiteMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Product>
 */
final class ProductFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    )
    {
        parent::__construct();
    }

    public static function class(): string
    {
        return Product::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $name = self::faker()->firstName();
        $prefix = strtoupper(substr($name, 0, 3));

        return [
            'active' => self::faker()->boolean(),
            'name' => $name,
            'serialNoPrefix' => $prefix,
            'category' => CategoryFactory::random(),
            'createdAt' => self::faker()->dateTime(),
            'description' => self::faker()->streetName(),
            'unit' => 'Unit',
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
//    protected function initialize(): static
//    {
//        return $this
//            ->afterPersist(function (Product $product)  {
//                $this->messageBus->dispatch(new AddProductMessage($product->getId()));
//            }) // default event for this factory
//            ;
//    }
}
