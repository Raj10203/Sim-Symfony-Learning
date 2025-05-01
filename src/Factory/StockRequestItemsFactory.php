<?php

namespace App\Factory;

use App\Entity\StockRequestItems;
use App\Enum\Stock\StockRequestStatus;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<StockRequestItems>
 */
final class StockRequestItemsFactory extends PersistentProxyObjectFactory
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
        return StockRequestItems::class;
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
            'product' => ProductsFactory::new(),
            'quantityApproved' => self::faker()->randomNumber(),
            'quantityRequested' => self::faker()->randomNumber(),
            'status' => self::faker()->randomElement(StockRequestStatus::cases()),
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
