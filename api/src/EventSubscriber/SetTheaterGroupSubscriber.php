<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Event;
use App\Repository\TheaterGroupRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

final class SetTheaterGroupSubscriber implements EventSubscriberInterface
{

  public function __construct(private Security $security, private TheaterGroupRepository $theaterGroupRepository)
  {
  }

  public static function getSubscribedEvents(): array
  {
    return [
      KernelEvents::VIEW => ["setTheaterGroup", EventPriorities::PRE_WRITE],
    ];
  }

  public function setTheaterGroup(ViewEvent $viewEvent): void
  {
    $event = $viewEvent->getControllerResult();
    $method = $viewEvent->getRequest()->getMethod();
    $isEvent = $event instanceof Event;
    $isPostMethod = Request::METHOD_POST === $method;

    if (!$isEvent || !$isPostMethod) {
      return;
    }

    $representative = $this->security->getUser();

    $verifiedTheaterGroup = $this->theaterGroupRepository->findOneBy([
      "representative" => $representative,
      "status" => "verified"
    ]);

    $event->setTheaterGroup($verifiedTheaterGroup);

    return;
  }
}