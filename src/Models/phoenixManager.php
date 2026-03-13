<?php
namespace ProjetA2Phoenix2026\Models;

use ProjetA2Phoenix2026\Models\livre;
/** Class UserManager **/
class phoenixManager {

    private $bdd;

    public function __construct() {
        $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getAll() {
         
        $stmt = $this->bdd->query("SELECT * FROM tp_travels");
        $stmt->setFetchMode(\PDO::FETCH_CLASS, phoenix::class);

        return $stmt->fetchAll();
    }

    public function create() {
        $stmt = $this->bdd->prepare("
            INSERT INTO tp_orders (reference, nb_personne, nb_week, total)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([
            $_POST['reference'], $_POST['nb_personne'], $_POST['nb_week'], $_POST['total']
        ]);
    }

    // test unitaire
    public function find1($name, $id)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM tp_travels WHERE name = ? AND id_travel = ?");
        $stmt->execute(array(
            $name,
            $id
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS, "ProjetA2Phoenix2026\Models\phoenix");

        return $stmt->fetch()->getId();
    }

   
   
}

