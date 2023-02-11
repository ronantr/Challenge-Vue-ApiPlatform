<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\TheaterGroup;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

final class SetRepresentativeSubscriber implements EventSubscriberInterface
{

  public function __construct(private Security $security)
  {
  }

  public static function getSubscribedEvents(): array
  {
    return [
      KernelEvents::VIEW => ["setRepresentative", EventPriorities::PRE_WRITE],
    ];
  }

  public function setRepresentative(ViewEvent $event): void
  {
    $theaterGroup = $event->getControllerResult();
    $method = $event->getRequest()->getMethod();
    $isTheaterGroup = $theaterGroup instanceof TheaterGroup;
    $isPostMethod = Request::METHOD_POST === $method;

    if (!$isTheaterGroup || !$isPostMethod) {
      return;
    }

    $representative = $this->security->getUser();

    $theaterGroup->setRepresentative($representative);
   
    return;
  }
}