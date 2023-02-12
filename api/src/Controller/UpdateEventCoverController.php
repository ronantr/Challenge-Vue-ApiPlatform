<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\TheaterGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Security;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[AsController]
class UpdateEventCoverController extends AbstractController
{
  public function __construct(
    private Security $security, 
    private EventRepository $eventRepository, 
    private TheaterGroupRepository $theaterGroupRepository,
    private ManagerRegistry $managerRegistry,
    )
  {
  }

  public function __invoke(Request $request)
  {
    $uploadedFile = $request->files->get('cover');

    if (!$uploadedFile) {
      throw new BadRequestHttpException('"cover" is required');
    }

    $user = $this->security->getUser();

    if (!$user) {
      throw new JsonResponse(["message" => "Unauthorized"], 401);
    }

    $eventId = $request->attributes->get('id');

    $event = $this->eventRepository->find(['id' => $eventId]);

    if (!$event) {
      throw new BadRequestHttpException('Event not found');
    }

    $theaterGroup = $event->getTheaterGroup();

    $representative = $theaterGroup->getRepresentative();

    if ($representative !== $user) {
      throw new JsonResponse(["message" => "Unauthorized"], 401);
    }
  
    $cover = new UploadedFile(
      $uploadedFile->getRealPath(),
      $uploadedFile->getClientOriginalName(),
      $uploadedFile->getMimeType(),
      $uploadedFile->getError(),
      true
    );

    $event->cover = $cover;

    // Triggers VichUploader update
    $event->updatedAt = new \DateTime();

    return $event;
  }
}