<?php

namespace App\Security\Voter;

use App\Entity\Book;
use App\Security\BookPermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class BookVoter extends Voter
{
    public function __construct(private AuthorizationCheckerInterface $authorizationChecker)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [BookPermission::EDIT_DETAILS, BookPermission::CHANGE_AVAILABILITY])
            && $subject instanceof Book;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            $vote?->addReason('The user must be logged in to access this resource.');

            return false;
        }

        return match ($attribute) {
            BookPermission::EDIT_DETAILS =>
            $this->authorizationChecker->isGranted(BookPermission::EDIT_DETAILS, $user) || $subject->getAddedBy() === $user,
            BookPermission::CHANGE_AVAILABILITY => $this->authorizationChecker->isGranted('ROLE_LIBRARIAN'),
            default => false,
        };


    }
}
