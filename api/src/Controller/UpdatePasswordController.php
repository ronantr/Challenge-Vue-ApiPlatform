<?php

namespace App\Controller;

use App\Entity\Token;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
class UpdatePasswordController extends AbstractController
{

  public function __construct(private RequestStack $requestStack, private ManagerRegistry $managerRegistry, private UserPasswordHasherInterface $passwordHasher, private ValidatorInterface $validator)
  {
  }

  public function __invoke()
  {
    $entityManager = $this->managerRegistry->getManager();

    $tokenRepository = $entityManager->getRepository(Token::class);

    $request = $this->requestStack->getCurrentRequest();

    $content = $request->getContent();

    $data = json_decode($content, true);

    $resetToken = $data['token'] ?? null;

    if (!$resetToken) {
      throw new UnprocessableEntityHttpException('Token is required');
    }

    if (!is_string($resetToken)) {
      throw new UnprocessableEntityHttpException('Token must be a string');
    }

    $existingToken = $tokenRepository->find($resetToken);

    if (!$existingToken) {
      throw new NotFoundHttpException('Token not found');
    }

    $isExpired = $existingToken->getExpireAt() < new \DateTimeImmutable();

    if ($isExpired) {
      $entityManager->remove($existingToken);

      $entityManager->flush();

      return new JsonResponse(["message" => 'Token is expired'], 401);
    }

    $user = $existingToken->getCustomer();

    $password = $data['password'] ?? null;

    $user->setPassword($password);

    $errors = $this->validator->validate($user);

    if (count($errors) > 0) {
      $formattedErrors = [];

      foreach ($errors as $error) {
        $formattedErrors[$error->getPropertyPath()] = $error->getMessage();
      }

      return new JsonResponse($formattedErrors, 422);
    }

    $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);

    $user->setPassword($hashedPassword);

    $entityManager->remove($existingToken);

    $entityManager->flush();

    return new JsonResponse(["message" => "Password has been reset"], 200);
  }
}