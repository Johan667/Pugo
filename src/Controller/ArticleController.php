<?php

namespace App\Controller;

use App\Manager\ArticleManager;
use Plugo\Controller\AbstractController;

class ArticleController extends AbstractController {

public function add() {
if (!empty($_POST)) {
$article = new Article();
$articleManager = new ArticleManager();
$article->setTitle($_POST['title']);
$article->setDescription($_POST['description']);
$article->setContent($_POST['content']);
$articleManager->add($article);
return $this->redirectToRoute('article_index');
}
return $this->renderView('article/add.php');
}

}

?>