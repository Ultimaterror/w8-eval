<?php

class Archer extends Character
{

    protected $quiver = 3;
    public $arrowDamage = 20;
    public $prepared = "no";

    public function __construct($name) {
        parent::__construct($name);
        $this->damage = 10;
    }

    public function turn($target) {
        $rand = rand(1, 10);
        if ($this->quiver == 0) {
            $status = $this->attack($target);
        } elseif ($rand > 8 && $this->quiver >= 2 && $this->prepared === "no") {
            $status = $this->doubleArrows();
        } elseif ($rand < 3 && $this->prepared === "no") {
            $status = $this->weakpoint();
        } elseif (($rand <= 8 && $rand >= 3) || $this->quiver >= 1) {
            $status = $this->shot($target);
        }
        return $status;
    }

    public function attack($target) {
        $target->setHealthPoints($this->damage);
        $status = "$this->name donne un coup de dague à $target->name ! Il reste $target->healthPoints points de vie à $target->name !";
        return $status;
    }

    public function doubleArrows() {
        $this->prepared = "doubleArrows";
        $status = "$this->name prépare sa prochaine attaque. Il sort 2 flèches de son carquois.";
        return $status;
    }

    public function weakpoint() {
        $this->prepared = "weakpoint";
        $status = "$this->name prépare sa prochaine attaque. Il cherche le point faible de son adversaire.";
        return $status;
    }

    public function shot($target) {
        if ($this->prepared === "weakpoint") {
            $attackDamage = $this->arrowDamage * rand(15, 30) / 10;
        } else {
            $attackDamage = $this->arrowDamage;
        }
        if ($this->prepared === "doubleArrows") {
            $this->quiver --;
            $target->setHealthPoints($attackDamage);
        }
        $this->quiver --;
        $target->setHealthPoints($attackDamage);
        $this->prepared = "no";
        $status = "$this->name tire avec son arc sur $target->name à qui il reste $target->healthPoints points de vie ! Il reste $this->quiver flèches à $this->name !";
        return $status;
    }

}