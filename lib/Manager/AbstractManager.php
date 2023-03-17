<?php

namespace Plugo\Manager;

require dirname(__DIR__, 2) . '/config/database.php';

abstract class AbstractManager {

    private function connect(): \PDO {
        // connexion a la bdd
        $db = new \PDO(
        "mysql:host=" . DB_INFOS['host'] . ";port=" . DB_INFOS['port'] . ";dbname=" . DB_INFOS['dbname'],
        DB_INFOS['username'],
        DB_INFOS['password']
        );
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $db->exec("SET NAMES utf8");
        return $db;
    }

    private function executeQuery(string $query, array $params = []): \PDOStatement {
        $db = $this->connect();
        $stmt = $db->prepare($query);
        foreach ($params as $key => $param) $stmt->bindValue($key, $param);
        $stmt->execute();
        return $stmt;
    }

    private function classToTable(string $class): string {
        // convertir le namespace d'une entité en nom de table
        $tmp = explode('\\', $class);
        return strtolower(end($tmp));
    }

    protected function readOne(string $class, array $filters): mixed {
        // La méthode readOne() est dédiée à la récupération d'une seule ressource.
        $query = 'SELECT * FROM ' . $this->classToTable($class) . ' WHERE ';
        foreach (array_keys($filters) as $filter) {
            $query .= $filter . " = :" . $filter;
            if ($filter != array_key_last($filters)) $query .= 'AND ';
        }
        $stmt = $this->executeQuery($query, $filters);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $stmt->fetch();
    }

    // La méthode readMany() est dédiée à la récupération de plusieurs ressources.
    protected function readMany(string $class, array $filters = [], array $order = [], int $limit = null, int $offset = null): mixed {
        $query = 'SELECT * FROM ' . $this->classToTable($class);
        if (!empty($filters)) {
            $query .= ' WHERE ';
            foreach (array_keys($filters) as $filter) {
                $query .= $filter . " = :" . $filter;
                if ($filter != array_key_last($filters)) $query .= 'AND ';
            }
        }
        if (!empty($order)) {
            $query .= ' ORDER BY ';
            foreach ($order as $key => $val) {
                $query .= $key . ' ' . $val;
                if ($key != array_key_last($order)) $query .= ', ';
            }
        }
        if (isset($limit)) {
            $query .= ' LIMIT ' . $limit;
            if (isset($offset)) {
                $query .= ' OFFSET ' . $offset;
            }
        }
        var_dump($query);
        $stmt = $this->executeQuery($query, $filters);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $stmt->fetchAll();
    }

 // La méthode create() est dédiée à l'enregistrement d'une ressource au sein d'une table. (CREATE)
    protected function create(string $class, array $fields): \PDOStatement {
        $query = "INSERT INTO " . $this->classToTable($class) . " (";
        foreach (array_keys($fields) as $field) {
            $query .= $field;
            if ($field != array_key_last($fields)) $query .= ', ';
        }
        $query .= ') VALUES (';
        foreach (array_keys($fields) as $field) {
            $query .= ':' . $field;
            if ($field != array_key_last($fields)) $query .= ', ';
        }
        $query .= ')';
        return $this->executeQuery($query, $fields);
    }

    // La méthode update() est dédiée à la modification d'une ressource au sein d'une table. (UPDATE)
    protected function update(string $class, array $fields, int $id): \PDOStatement {
        $query = "UPDATE " . $this->classToTable($class) . " SET ";
        foreach (array_keys($fields) as $field) {
            $query .= $field . " = :" . $field;
            if ($field != array_key_last($fields)) $query .= ', ';
        }
        $query .= ' WHERE id = :id';
        $fields['id'] = $id;
        return $this->executeQuery($query, $fields);
    }

    // La méthode delete() est dédiée à la suppression d'une ressource au sein d'une table. (DELETE)

        protected function delete(string $class, int $id): \PDOStatement {
            $query = "DELETE FROM " . $this->classToTable($class) . " WHERE id = :id";
            return $this->executeQuery($query, [ 'id' => $id ]);
        }

}