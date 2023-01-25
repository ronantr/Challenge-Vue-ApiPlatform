<?php
namespace App\Service;

use App\Entity\User;
use App\Repository\LevelRepository;

class UserLevelService
{
    public function __construct(
        private LevelRepository $levelRepository,
    ) {

    }

    public function updateUserLevel(User $user)
    {
        $level = $user->getLevel();
        $points = $user->getPoints();
        $pointsRequired = $level->getPointsRequired();
        $maxLevelNumber = $this->levelRepository->getMaxLevel()->getLevelNumber();
        if ($points >= $pointsRequired && !$level->isMaxLevel($maxLevelNumber)) {
            $nextLevel = $this->levelRepository->getNextLevel($level->getLevelNumber());
            $user->setLevel($nextLevel);
        }
    }

}
