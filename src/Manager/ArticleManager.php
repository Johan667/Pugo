<?php
namespace App\Manager;

use Plugo\Manager\AbstractManager;
use App\Entity\Article;

// Gestionnaire d'article


class ArticleManager extends AbstractManager {


    public function find(int $id) {
        // find by ID
        return $this->readOne(Article::class, [ 'id' => $id ]);
    }

    public function findOneBy(array $filters) {
        // find One By

        return $this->readOne(Article::class, $filters);
    }

    public function findAll() {

        // FindAll
        return $this->readMany(Article::class);
    }

    public function findBy(array $filters, array $order = [], int $limit = null, int $offset = null) {
        // Récupération par filtre
        return $this->readMany(Article::class, $filters, $order, $limit, $offset);
    }

    public function add(Article $article) {
        // Fonction add
        return $this->create(Article::class, [
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
                'content' => $article->getContent()
            ]
        );
    }

    public function edit(Article $article) {
        // Fonction modifier
        return $this->update(Article::class, [
            'title' => $article->getTitle(),
            'description' => $article->getDescription(),
            'content' => $article->getContent()
        ],
            $article->getId()
        );
    }

    public function remove(Article $article) {
        // Fonction supprimer
        return $this->delete(Article::class, $article->getId());
    }



}