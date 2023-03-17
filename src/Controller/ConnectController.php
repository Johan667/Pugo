<?php

namespace App\Controller;

use App\Entity\User;
use App\Manager\ArticleManager;
use Model\Connect;
use Plugo\Controller\AbstractController;
use App\Manager\UserManager;

// Contrôleurs pour les connexions et inscriptions

class ConnectController extends AbstractController {


    public function inscription() {
        $nickname = filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($nickname && $email && $password) {

            $user = new User();
            $UserManager = new UserManager();
            $user->setNickname($_POST['nickname']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $UserManager->add($user);
            return $this->redirectToRoute('home');

        }
        return $this->renderView('inscription.php',
            ['title' => 'Inscription']);
    }

    public function login() {

// chercher user en bdd avec son email -> verif si il existe
        // verif mdp password verify

        // si tout ok create session();

        return $this->renderView('login.php',
            ['title' => 'Login']);

    }



}