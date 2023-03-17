<?php


const ALIASES = [
    'Plugo' => 'lib',
    'App' => 'src'
];
// L'objectif de ce tableau est de travailler en conservant de bonnes conventions de nommage au niveau de nos dossiers

spl_autoload_register(function (string $class): void {
    // La fonction spl_autoload_register() sera exécutée à chaque utilisation d'une classe.

    $namespaceParts = explode('\\', $class);

    if (in_array($namespaceParts[0], array_keys(ALIASES))) {
        $namespaceParts[0] = ALIASES[$namespaceParts[0]];
    } else {
        throw new Exception('Namespace « ' . $namespaceParts[0] . ' » invalide. Un namespace doit commencer par : « Plugo » ou « App »');
    }

    $filepath = dirname(__DIR__) . '/' . implode('/', $namespaceParts) . '.php';
    // Pour inclure automatiquement une classe
    if (!file_exists($filepath)) {
        throw new Exception("Fichier « " . $filepath . " » introuvable pour la classe « " . $class . " ». Vérifier le chemin, le nom de la classe ou le namespace");
    }
    require $filepath;

});

?>