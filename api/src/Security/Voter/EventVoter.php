<?php

namespace App\Security\Voter;

use App\Entity\Event;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class EventVoter extends Voter
{
    public const EDIT = 'edit';
    public const VIEW = 'view';
    public const DELETE = 'delete';
    public const CREATE = 'create';
    private $security;

    public function __construct(Security $security)
    {

        $this->security = $security;
    }
    
    protected function supports(string $attribute, $subject): bool
    {

        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE, self::CREATE])
            && $subject instanceof Event;
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

            case self::CREATE:
                return $this->canCreate($subject, $user);
                break;
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
        dd($subject->getTheaterGroup()->getId());
        if($this->security->isGranted('ROLE_ADMIN') || $user === $subject->getTheaterGroup()){
            return true;
        }
        return false;
    }

    private function canView($subject, $user): bool
    {
        return $this->canEdit($subject, $user);
    }

    private function canDelete($subject, $user): bool
    {
        return $this->canEdit($subject, $user);
    }

    private function canCreate($subject, $user): bool
    {
        return $this->security->isGranted('ROLE_THEATER');
    }
}
