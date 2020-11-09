<?php

namespace App\Controller\Action;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class GetNotCancelled extends AbstractController
{
   
    public function __invoke()
    {
        /** @var Command $commands */
        $data = [];
        $user = $this->getUser();
        $allCommands = $user->getCommands();
        foreach ($allCommands as $command) {
            if ($command->getStatus() !== "annulée") {
                $data[] = $command;
            }
        }
        return $data;
    }
}
