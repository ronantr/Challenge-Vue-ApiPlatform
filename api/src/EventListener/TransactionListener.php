<?php

namespace App\EventListener;

use App\Entity\Transaction;
use App\Repository\LevelRepository;
use App\Service\UserLevelService;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class TransactionListener 
{
    private $levelRepository;
    private $userLevelService;
    private $security;

    public function __construct(LevelRepository $levelRepository, UserLevelService $userLevelService,Security $security)
    {
        $this->levelRepository = $levelRepository;
        $this->userLevelService = $userLevelService;
        $this->security = $security;

    }

    public function prePersist(LifecycleEventArgs $event)
    {
        
        $entity = $event->getEntity();
        if (!$entity instanceof Transaction) {
            return;
        }
        if (!$this->security->isGranted('ROLE_USER')) {
            return;
        }
        
        $transaction = $event->getEntity();
        // dd($transaction);
        $user = $transaction->getUser();
        $points = $user->getPoints();
        // Calculate the new points for the user
        $newPoints = $points + ($transaction->getAmount() * 1); // 1€ = 1 point

        // Update the user's points
        $user->setPoints($newPoints);

        // Retrieve the bonus percentage for the user's current level
        $bonusPercentage = $transaction->getUser()->getLevel()->getBonusPercentage();

        // Calculate the bonus for the transaction
        $bonus = $transaction->getAmount() * ($bonusPercentage / 100);
        $transaction->setBonusAmount($bonus);

        //update credit (amount + bonus)
        $transaction->getUser()->addCredit($transaction->getAmount() + $transaction->getBonusAmount());

        // Add the bonus to the transaction amount
        $transaction->setAmount($transaction->getAmount());


        // Update the user's level if the user's points exceeds the required points for the next level
        $level = $user->getLevel();
        $pointsRequired = $level->getPointsRequired();

        $nextLevel = $this->levelRepository->getNextLevel($level->getLevelNumber());
        $maxLevel = $this->levelRepository->getMaxLevel();
        if ($points >= $pointsRequired && !$level->isMaxLevel($maxLevel->getLevelNumber())) {
            $nextLevel = $this->levelRepository->getNextLevel($level->getLevelNumber());
            $user->setLevel($nextLevel);
        }
    }
}