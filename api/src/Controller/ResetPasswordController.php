<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\MailerService;
use App\Entity\Token;

#[AsController]
class ResetPasswordController extends AbstractController
{

  public function __construct(private RequestStack $requestStack, private ManagerRegistry $managerRegistry, private MailerService $mailerService)
  {
  }

  public function __invoke()
  {
    $entityManager = $this->managerRegistry->getManager();

    $userRepository = $entityManager->getRepository(User::class);

    $request = $this->requestStack->getCurrentRequest();

    $content = $request->getContent();

    $data = json_decode($content, true);

    $email = $data['email'] ?? null;

    if (!$email) {
      throw new UnprocessableEntityHttpException('Email is required');    
    }

    if (!is_string($email)) {
      throw new UnprocessableEntityHttpException('Email must be a string');
    }

    $user = $userRepository->findOneBy(['email' => $email]);

    if (!$user) {
      throw new NotFoundHttpException('User not found');
    }

    $tokenRepository = $entityManager->getRepository(Token::class);

    $oldTokens = $tokenRepository->findBy(['customer' => $user]);

    foreach ($oldTokens as $oldToken) {
      $entityManager->remove($oldToken);
    }

    $tokenId = bin2hex(random_bytes(16));

    $resetToken = new Token();

    $resetToken
      ->setCustomer($user)
      ->setId($tokenId)
      ->setExpireAt(new \DateTimeImmutable("+1 day"));

    $entityManager->persist($resetToken);

    $entityManager->flush();

    $templateId = 2;

    $params = [
      "firstName" => $user->getFirstName(),
      "resetLink" => "http://localhost:5173/update-password?token=" . $tokenId,
    ];

    $this->mailerService->sendMail($user, $templateId, $params);

    return new JsonResponse(["message" => "Reset password email sent"], 200);
  }
}