<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    public const EDIT = 'edit';
    public const VIEW = 'view';
    public const DELETE = 'delete';
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW], self::DELETE)
            && $subject instanceof User;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
                break;
            case self::VIEW:
                return $this->canView($subject, $user);
                break;
            case self::DELETE:
                return $this->canDelete($subject, $user);
                break;
        }

        return false;
    }

    private function canEdit($subject, $user): bool
    {
        if($this->security->isGranted('ROLE_ADMIN') || $user === $subject){
            return true;
        }
    }

    private function canView($subject, $user): bool
    {
        return $this->canEdit($subject, $user);
    }

    private function canDelete($subject, $user): bool
    {
        return $this->canEdit($subject, $user);
    }
}
