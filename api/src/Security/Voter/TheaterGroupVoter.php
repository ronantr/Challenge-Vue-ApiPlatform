<?php

namespace App\Security\Voter;

use App\Repository\TheaterGroupRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\TheaterGroup;

class TheaterGroupVoter extends Voter
{
  public const CREATE = 'theater_group_create';

  public function __construct(private TheaterGroupRepository $theaterGroupRepository)
  {
  }

  protected function supports(string $attribute, $subject): bool
  {
    return $attribute === self::CREATE && $subject instanceof TheaterGroup;
  }

  protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
  {
    $representative = $token->getUser();

    if (!$representative instanceof UserInterface) {
      return false;
    }

    return $this->canCreate($representative);
  }

  private function canCreate($representative): bool
  {
    $notClosedTheaterGroup = $this->theaterGroupRepository->findNotClosedTheaterGroupsByRepresentative($representative);

    return count($notClosedTheaterGroup) === 0;
  }
}