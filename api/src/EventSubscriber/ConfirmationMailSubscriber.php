<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Token;
use App\Entity\User;
use App\Service\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Doctrine\ORM\EntityManagerInterface;

final class ConfirmationMailSubscriber implements EventSubscriberInterface
{

  public function __construct(private MailerService $mailerService, private EntityManagerInterface $entityManager)
  {
  }

  public static function getSubscribedEvents(): array
  {
    return [
      KernelEvents::VIEW => ["sendConfirmationMail", EventPriorities::POST_WRITE],
    ];
  }

  public function sendConfirmationMail(ViewEvent $event): void
  {
    /** @var User $user */
    $user = $event->getControllerResult();
    $method = $event->getRequest()->getMethod();
    $isUser = $user instanceof User;
    $isPostMethod = Request::METHOD_POST === $method;
  

    if (!$isUser || !$isPostMethod) {
      return;
    }

    $confirmationToken = new Token();

    $tokenId = bin2hex(random_bytes(16));

    $confirmationToken
      ->setCustomer($user)
      ->setId($tokenId)
      ->setExpireAt(new \DateTimeImmutable("+1 day"));

    $templateId = 1;

    $params = [
      "firstName" => $user->getFirstName(),
      "confirmationLink" => "http://localhost:5173/verify?token=" . $tokenId,
    ];

    $this->mailerService->sendMail($user, $templateId, $params);

    $this->entityManager->persist($confirmationToken);

    $this->entityManager->flush();
  }
}