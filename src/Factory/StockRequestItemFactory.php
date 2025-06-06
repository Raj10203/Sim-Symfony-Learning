<?php

namespace App\Factory;

use App\Entity\StockRequestItem;
use App\Enum\StockRequestItemsStatus;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<StockRequestItem>
 */
final class StockRequestItemFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return StockRequestItem::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'createdAt' => self::faker()->dateTime(),
            'product' => ProductFactory::random(),
            'quantityApproved' => self::faker()->randomNumber(),
            'quantityRequested' => self::faker()->randomNumber(),
            'status' => self::faker()->randomElement(StockRequestItemsStatus::cases()),
            'stockRequest' => StockRequestFactory::random(),
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this// ->afterInstantiate(function(StockRequestItems $stockRequestItems): void {})
            ;
    }
}
