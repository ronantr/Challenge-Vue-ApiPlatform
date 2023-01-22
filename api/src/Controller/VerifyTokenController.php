<?php

namespace App\Controller;

use App\Entity\Token;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VerifyTokenController extends AbstractController
{

  public function __construct(private RequestStack $requestStack, private JWTTokenManagerInterface $JWTManager, private ManagerRegistry $managerRegistry)
  {
  }

  public function __invoke()
  {
    $entityManager = $this->managerRegistry->getManager();

    $tokenRepository = $entityManager->getRepository(Token::class);

    $request = $this->requestStack->getCurrentRequest();

    $content = $request->getContent();

    $data = json_decode($content, true);

    $confirmationToken = $data['token'] ?? null;

    if (!$confirmationToken) {
      throw new UnprocessableEntityHttpException('Token is required');    
    }

    $existingToken = $tokenRepository->findOneBy(['id' => $confirmationToken]);

    if (!$existingToken) {
      throw new NotFoundHttpException('Token not found');
    }

    $isExpired = $existingToken->getExpireAt() < new \DateTimeImmutable();

    if ($isExpired) {
      $entityManager->remove($existingToken);

      $entityManager->flush();

      return new Response('Token is expired', 401);
    }

    $user = $existingToken->getCustomer();

    $user->setIsVerified(true);

    $entityManager->persist($user);

    $entityManager->remove($existingToken);

    $entityManager->flush();

    $token = $this->JWTManager->create($user);

    return $this->json(['token' => $token]);
  }
}