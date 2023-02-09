<?php

namespace App\Security\Voter;

use App\Repository\TheaterGroupRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\TheaterGroup;
use Symfony\Component\HttpFoundation\RequestStack;

class TheaterGroupVoter extends Voter
{
  public const CREATE = 'theater_group_create';
  public const VIEW_STATUS = 'theater_group_view_status';

  public function __construct(private TheaterGroupRepository $theaterGroupRepository, private RequestStack $requestStack)
  {
  }

  protected function supports(string $attribute, $subject): bool
  {
    $isTheaterGroup = $subject instanceof TheaterGroup;
    $isSupportedAttribute = in_array($attribute, [self::CREATE, self::VIEW_STATUS]);

    return $isTheaterGroup && $isSupportedAttribute;
  }

  protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
  {
    $representative = $token->getUser();

    if (!$representative instanceof UserInterface) {
      return false;
    }

    switch ($attribute) {
      case self::CREATE:
        return $this->canCreate($representative);

      case self::VIEW_STATUS:
        return $this->canViewStatus($representative, $subject);
    }

    return false;
  }

  private function canCreate($representative): bool
  {
    $notClosedTheaterGroup = $this->theaterGroupRepository->findNotClosedTheaterGroupsByRepresentative($representative);

    return count($notClosedTheaterGroup) === 0;
  }

  private function canViewStatus($representative, $subject): bool
  {
    $request = $this->requestStack->getCurrentRequest();

    $method = $request->getMethod();

    $isGetMethod = $method === 'GET';

    if ($isGetMethod) {
      return $representative === $subject->getRepresentative();
    }

    return false;
  }
}