<?php
namespace ProjetA2Phoenix2026\Models;

/** Class Todo **/
class phoenix {

    private $name;
    private $id_travel;
    private $id_category;
    private $title;
    private $description;
    private $image;
    private $price;


    public function getId() {
        return $this->id_travel;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getImage() {
        return $this->image;
    }

    public function getPrice() {
        return $this->price;
    }

    public function travel()
    {
        $manager = new UserManager();
        if (!$this->tp_travels) {
            $this->tp_travels = $manager->getAll($this->getId());
        }

        return $this->travels;
    }

    public function setId(Int $id_travel) {
        $this->id_travel = $id_travel;
    }

    public function setName(String $name) {
        $this->name = $name;
    }

    public function setImage(String $image) {
        $this->image = $image;
    }

    public function setPrice(String $price) {
        $this->price = $price;
    }

    public function setDescription(String $description) {
        $this->description = $description;
    }


}