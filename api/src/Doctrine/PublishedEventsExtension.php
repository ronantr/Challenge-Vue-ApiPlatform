<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Event;
use App\Repository\TheaterGroupRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

final class PublishedEventsExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

  public function __construct(private Security $security, private TheaterGroupRepository $theaterGroupRepository)
  {
  }

  public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
  {    
    $this->addWhere($queryBuilder, $resourceClass);
  }

  public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void
  {
    $this->addWhere($queryBuilder, $resourceClass);
  }

  private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
  {
    $isEvent = $resourceClass === Event::class;
    $isAdmin = $this->security->isGranted('ROLE_ADMIN');
    $user = $this->security->getUser();

    if (!$isEvent || $isAdmin || !$user) {
      return;
    }

    $verifiedTheaterGroup = $this->theaterGroupRepository->findOneBy([
      'representative' => $user,
      'status' => 'verified'
    ]);
    
    $rootAlias = $queryBuilder->getRootAliases()[0];
    $queryBuilder->andWhere(sprintf('%s.isPublished = :isPublished OR %s.theaterGroup = :verifiedTheaterGroup', $rootAlias, $rootAlias));
    $queryBuilder->setParameter('isPublished', true);
    $queryBuilder->setParameter('verifiedTheaterGroup', $verifiedTheaterGroup);
  }
}