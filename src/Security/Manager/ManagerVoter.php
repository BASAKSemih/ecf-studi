<?php

declare(strict_types=1);

namespace App\Security\Manager;

use App\Entity\Hotel;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class ManagerVoter extends Voter
{
    protected function supports(string $attribute, $subject): bool
    {
        return 'IS_OWNER' === $attribute
            && $subject instanceof Hotel;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $manager = $token->getUser();

        /** @var Hotel $subject */
        return $subject->getManager() === $manager;
    }
}
