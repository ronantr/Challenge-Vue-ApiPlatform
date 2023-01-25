<?php

use App\Entity\Transaction;
use App\Repository\LevelRepository;
use App\Service\UserLevelService;

class TransactionListener
{
    private $levelRepository;
    private $userLevelService;

    public function __construct(LevelRepository $levelRepository, UserLevelService $userLevelService)
    {
        $this->levelRepository = $levelRepository;
        $this->userLevelService = $userLevelService;

    }

    public function prePersist(Transaction $transaction)
    {
        $user = $transaction->getUser();
        $points = $user->getPoints();
        // Calculate the new points for the user
        $newPoints = $points + ($transaction->getAmount() * 1); // 1€ = 1 point

        // Update the user's points
        $user->setPoints($newPoints);

        //update credit
         $transaction->getUser()->addCredit($transaction->getAmount());

        // Retrieve the bonus percentage for the user's current level
        $bonusPercentage = $transaction->getUser()->getLevel()->getBonusPercentage();

        // Calculate the bonus for the transaction
        $bonus = $transaction->getAmount() * ($bonusPercentage / 100);
        $transaction->setBonusAmount($bonus);

        // Add the bonus to the transaction amount
        $transaction->setAmount($transaction->getAmount() + $bonus);

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