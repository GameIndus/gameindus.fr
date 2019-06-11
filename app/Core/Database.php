<?php
#
# GameIndus - A free online platform to imagine, create and publish your game with ease!
#
# GameIndus website
# Copyright (c) 2015-2018 Maxime Malgorn (Utarwyn)
# <https://github.com/GameIndus/gameindus.fr>
#

namespace GameIndus\Core;

use PDO;
use PDOException;

class Database
{

    /**
     * @var array Credential object for the connection
     */
    public $db = array();

    /**
     * @var PDO MySQL connection object
     */
    public $pdo;

    /**
     * @var string Last request sended to the database
     */
    public $lastRequest;

    public function __construct($host, $pseudobdd, $passbdd, $namebdd)
    {
        // Initialize credential object for the MySQL connection
        $this->db = array(
            'host' => $host,
            'user' => $pseudobdd,
            'pass' => $passbdd,
            'database' => $namebdd
        );
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . $this->db['host'] . ';dbname=' . $this->db['database'], $this->db['user'], $this->db['pass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function find($req = null)
    {
        if (is_null($this->pdo)) {
            $this->connect();
        }

        $sql = 'SELECT ';

        if (!empty($req['fields'])) {
            $fields = $req['fields'];

            if (is_string($fields)) {
                if (strpos($req['fields'], '(') !== false) {
                    $sql .= $req['fields'];
                } else {
                    $sql .= '`' . $req['fields'] . '`';
                }
            } else if (is_array($fields)) {
                foreach ($fields as $field) $sql .= '`' . $field . '`,';
                if (substr($sql, -1) == ',') $sql = substr($sql, 0, -1);
            } else {
                $sql .= '*';
            }

        } else {
            $sql .= '*';
        }

        $sql .= ' FROM ';

        if (!empty($req['table'])) {
            $sql .= $req['table'];
        } else {
            return 'Erreur : Aucune table n\'est utilisée !';
        }

        if (!empty($req['conditions'])) {
            $sql .= ' WHERE ';
            $numberOfValues = count($req['conditions']);
            $i = 1;
            foreach ($req['conditions'] as $k => $v) {
                if ($i == $numberOfValues) {
                    $sql .= "`$k` = :cond$i ";
                } else {
                    $sql .= "`$k` = :cond$i AND ";
                }
                $i++;
            }
        }

        if (!empty($req['like'])) {
            $sql .= ' WHERE `' . $req['likename'] . '` LIKE :like ';
        }

        if (!empty($req['order'])) {
            $sql .= ' ORDER BY ' . $req['order'];
        }

        if (!empty($req['limit'])) {
            $sql .= ' LIMIT ' . $req['limit'];
        }

        $this->lastRequest = $sql;

        if (isset($this->pdo) && !empty($this->pdo)) {
            $pre = $this->pdo->prepare($sql);
        } else {
            return 'Il faut se connecter à la BDD avant de pouvoir utiliser cette fonction !';
        }

        // Binding values (prevent for hacks)
        if (!empty($req['conditions'])) {
            $i = 1;
            foreach ($req['conditions'] as $k => $v) {
                $pre->bindValue("cond$i", $v);
                $i++;
            }
        }
        if (!empty($req['like'])) {
            $pre->bindValue("like", "%{$req['like']}%", PDO::PARAM_STR);
        }

        $exec = $pre->execute();
        return $pre->fetchAll(PDO::FETCH_OBJ);
    }

    public function findFirst($req = null)
    {
        return current($this->find($req));
    }

    public function save($req = null)
    {
        if (is_null($this->pdo)) {
            $this->connect();
        }

        if (!isset($req['where'])) {
            $sql = "INSERT INTO `{$req['table']}` (";
            $total = count($req['fields']);
            $i = 1;
            foreach ($req['fields'] as $k => $v) {
                if ($i == $total) {
                    $sql .= "`$k`";
                } else {
                    $sql .= "`$k`,";
                }
                $i++;
            }
            $sql .= ") VALUES (";
            $i2 = 1;
            foreach ($req['fields'] as $k => $v) {
                if ($i2 == $total) {
                    $sql .= ":field$i2";
                } else {
                    $sql .= ":field$i2,";
                }
                $i2++;
            }
            $sql .= ")";

            $this->lastRequest = $sql;
            $pre = $this->pdo->prepare($sql);

            // Binding values
            $i3 = 1;
            foreach ($req['fields'] as $k => $v) {
                $pre->bindValue("field$i3", $v);
                $i3++;
            }

            return $pre->execute();
        } else {
            $sql = "UPDATE `{$req['table']}` SET ";
            $total = count($req['fields']);
            $i = 1;

            foreach ($req['fields'] as $k => $v) {
                if ($i == $total) {
                    $sql .= " `$k` = :field$i ";
                } else {
                    $sql .= " `$k` = :field$i, ";
                }
                $i++;
            }
            $sql .= " WHERE `{$req['where']}` = :wherevalue";

            $this->lastRequest = $sql;
            $pre = $this->pdo->prepare($sql);

            // Binding values
            $i = 1;
            foreach ($req['fields'] as $k => $v) {
                $pre->bindValue("field$i", $v);
                $i++;
            }
            $pre->bindValue("wherevalue", $req['wherevalue']);

            return $pre->execute();
        }
    }

    public function delete($req = null)
    {
        if (is_null($this->pdo)) {
            $this->connect();
        }

        $sql = "DELETE FROM {$req['table']} WHERE {$req['where']} = '{$req['wherevalue']}'";
        $this->lastRequest = $sql;

        $req = $this->pdo->prepare($sql);
        $req->execute();
    }

    public function count($req = null)
    {
        if (empty($req["fields"])) $req["fields"] = "*";
        $req["fields"] = "COUNT({$req["fields"]}) as c";

        $this->lastRequest = $req;
        $sql = $this->find($req);

        return ((empty($sql) ? -1 : $sql{0}->c));
    }

    public function req($sql, $input_parameters = null)
    {
        if (is_null($this->pdo)) {
            $this->connect();
        }

        $req = $this->pdo->prepare($sql);
        $this->lastRequest = $sql;

        $req->execute($input_parameters);
        return $req->fetchAll(PDO::FETCH_OBJ);
    }

    public function escape_string($string)
    {
        return addslashes($string);
    }

    public function getLastID()
    {
        if (!is_null($this->pdo)) {
            return $this->pdo->lastInsertId();
        } else {
            return -1;
        }
    }

}
