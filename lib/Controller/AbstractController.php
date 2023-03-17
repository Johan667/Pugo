<?php

namespace Plugo\Controller;

// Controlleur frontale

abstract class AbstractController {

    protected function renderView(string $template, array $data = []): string {
        // fonction du controller qui rends une vue en fonction du chemin dans le dossier templates
        $templatePath = dirname(__DIR__, 2) . '/templates/' . $template;
        return require_once dirname(__DIR__, 2) . '/templates/layout.php';
    }

    protected function redirectToRoute(string $name, array $params = []): void {
        // Cette fonction permet de rediriger
        $uri = $_SERVER['SCRIPT_NAME'] . "?page=" . $name;

        if (!empty($params)) {
            $strParams = [];
            foreach ($params as $key => $val) {
                array_push($strParams, urlencode((string) $key) . '=' . urlencode((string) $val));
            }
            $uri .= '&' . implode('&', $strParams);
        }

        header("Location: " . $uri);
        die;
    }


}