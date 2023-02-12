<?php

namespace App\Security\Voter;

use App\Repository\TheaterGroupRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use App\Entity\Event;
use Symfony\Component\Security\Core\Security;

class EventVoter extends Voter
{
  public const CREATE = 'event_create';

  public function __construct(private Security $security, private TheaterGroupRepository $theaterGroupRepository)
  {
  }

  protected function supports(string $attribute, $subject): bool
  {
    $isEvent = $subject instanceof Event;
    $isSupportedAttribute = in_array($attribute, [self::CREATE]);

    return $isEvent && $isSupportedAttribute;
  }

  protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
  {
    switch ($attribute) {
      case self::CREATE:
        return $this->canCreate();
    }

    return false;
  }

  private function canCreate(): bool
  {
    $representative = $this->security->getUser();

    $verifiedTheaterGroup = $this->theaterGroupRepository->findOneBy([
      'representative' => $representative,
      'status' => 'verified',
    ]);

    if (!$verifiedTheaterGroup) {
      return false;
    }
    
    return true;
  }
}