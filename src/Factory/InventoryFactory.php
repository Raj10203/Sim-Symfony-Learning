<?php

namespace App\Factory;

use App\Entity\Inventory;
use App\Messenger\Message\AddProductMessage;
use App\Messenger\Message\AddStockToSiteMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Inventory>
 */
final class InventoryFactory extends PersistentProxyObjectFactory
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
    }

    public static function class(): string
    {
        return Inventory::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'product' => ProductFactory::new(),
            'quantity' => rand(1, 20),
            'site' => SiteFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
//    protected function initialize(): static
//    {
//        return $this
//             ->afterPersist(function(Inventory $inventory): void {
//                 $this->messageBus->dispatch(new AddStockToSiteMessage($inventory->getId(),$inventory->getQuantity()));
//             })
//        ;
//    }
}
