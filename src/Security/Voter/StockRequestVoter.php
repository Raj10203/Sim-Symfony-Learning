<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Enum\Stock\StockRequestStatus;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class StockRequestVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const VIEW = 'VIEW';
    public const DELETE = 'DELETE';

    public function __construct(private Security $security)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof \App\Entity\StockRequest;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if (!$subject instanceof \App\Entity\StockRequest) {
            return false;
        }
        if ($this->security->isGranted('ROLE_ADMIN')
            || $this->security->isGranted('ROLE_STOCK_REQUEST_REVIEWER')
        ) {
            return true;
        }

        return match ($attribute) {
            self::DELETE, self::EDIT => ($subject->getToSite() === $user->getSite() &&
                $subject->getStatus() == StockRequestStatus::Draft),
            self::VIEW => ($subject->getToSite() === $user->getSite() || $subject->getFromSite() === $user->getSite()),
            default => false,
        };
    }
}
