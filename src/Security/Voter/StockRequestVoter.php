<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class StockRequestVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const VIEW = 'VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW])
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
        if (in_array('ROLE_ADMIN', $user->getRoles(), true) ||
            in_array('ROLE_STOCK_REQUEST_REVIEWER', $user->getRoles(), true)) {
            return true;
        }

        switch ($attribute) {
            case self::EDIT:
                return $subject->getToSite() === $user->getSite();
                break;

            case self::VIEW:
                return ($subject->getToSite() === $user->getSite() || $subject->getFromSite() === $user->getSite());
                break;
        }

        return false;
    }
}
