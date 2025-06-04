<?php

namespace App\Factory;

use App\Entity\StockRequest;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<StockRequest>
 */
final class StockRequestFactory extends PersistentProxyObjectFactory
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
        return StockRequest::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        $fromSite = SiteFactory::random();
        $toSite = SiteFactory::random();

        while ($toSite->getId() === $fromSite->getId()) {
            $toSite = SiteFactory::random();
        }
        return [
            'createdAt' => self::faker()->dateTime(),
            'fromSite' => $fromSite,
            'requestedBy' => UserFactory::random(),
            'status' => self::faker()->randomElement(['draft', 'pending_hq_employee', 'pending_manager', 'pending_admin', 'approved', 'rejected']),
            'toSite' => $toSite,
            'updatedAt' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(StockRequest $stockRequest): void {})
        ;
    }
}
