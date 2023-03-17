<?php

namespace App\Controller;

use Plugo\Controller\AbstractController;

// Contrôleurs applicatif

class MainController extends AbstractController {

    public function home() {
        return $this->renderView('home.php',
            ['title' => 'Accueil']);
    }


}