<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Repository\TheaterGroupRepository;

#[AsController]
class GetTheaterGroupEventsController extends AbstractController
{

  public function __construct(private RequestStack $requestStack, private Security $security, private EventRepository $eventRepository, private TheaterGroupRepository $theaterGroupRepository)
  {
  }

  public function __invoke()
  {
    $request = $this->requestStack->getCurrentRequest();
    $id = $request->attributes->get('id');

    $representative = $this->security->getUser();

    $verifiedTheaterGroup = $this->theaterGroupRepository->findOneBy([
      'id' => $id,
      'representative' => $representative,
      'status' => 'verified'
    ]);

    if (!$verifiedTheaterGroup) {
      throw new AccessDeniedHttpException('You are not allowed to access this resource');
    }

    $events = $this->eventRepository->findBy([
      'theaterGroup' => $verifiedTheaterGroup
    ]);

    return $events;

  }
}