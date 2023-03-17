<?php

namespace App\Manager;

use App\Entity\Article;
use Plugo\Manager\AbstractManager;
use App\Entity\User;

Class UserManager extends AbstractManager {

    public function add(User $user)
    {
        // Fonction add
        return $this->create(User::class, [
                'nickname' => $user->getNickname(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ]
        );

    }

}
