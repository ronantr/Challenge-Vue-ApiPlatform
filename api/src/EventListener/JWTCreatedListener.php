<?php

namespace App\EventListener;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{

  public function __construct(private UserRepository $userRepository)
  {
  }

  public function __invoke(JWTCreatedEvent $event)
  {
    $payload = $event->getData();
    $user = $this->userRepository->findOneBy(['email' => $payload['email']]);

    $payload['sub'] = $user->getId();
    
    $event->setData($payload);
  }

}