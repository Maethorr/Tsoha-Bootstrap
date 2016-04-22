<?php

class Luokka extends BaseModel {

    public $id, $kayttajaid, $nimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->tarkistukset = array('tarkista_nimi', 'tarkista_nimi2');
    }

    public static function all() {
        $kysely = DB::connection()->prepare('SELECT * FROM Luokka WHERE kayttajaid = :kayttajaid');
        $kysely->execute(array('kayttajaid' => $_SESSION['kayttajaid']));
        $rivit = $kysely->fetchAll();
        $luokat = array();

        foreach ($rivit as $rivi) {
            $luokat[] = new Luokka(array(
                'id' => $rivi['id'],
                'kayttajaid' => $rivi['kayttajaid'],
                'nimi' => $rivi['nimi']
            ));
        }

        return $luokat;
    }

    public static function find($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Luokka WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));
        $rivi = $kysely->fetch();

        if ($rivi) {
            $luokka = new Luokka(array(
                'id' => $rivi['id'],
                'kayttajaid' => $rivi['kayttajaid'],
                'nimi' => $rivi['nimi']
            ));
        }

        return $luokka;
    }

    public function save() {
        $kysely = DB::connection()->prepare('INSERT INTO Luokka (kayttajaid, nimi) VALUES (:kayttajaid, :nimi) RETURNING id');
        $kysely->execute(array('kayttajaid' => $this->kayttajaid, 'nimi' => $this->nimi));
        $rivi = $kysely->fetch();
        $this->id = $rivi['id'];
    }

    public function tarkista_nimi() {
        $virheet = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $virheet[] = 'Luokalla täytyy olla nimi';
        }
        return $virheet;
    }

    public function tarkista_nimi2() {
        $virheet = array();
        if (strlen($this->nimi) > 50) {
            $virheet[] = 'Luokan nimen enimmäispituus on 50 merkkiä';
        }
        return $virheet;
    }

    public function paivita() {
        $kysely = DB::connection()->prepare('UPDATE Luokka set (nimi) = (:nimi) WHERE id = :id');
        $kysely->execute(array('id' => $this->id, 'nimi' => $this->nimi));
        $rivi = $kysely->fetch();
    }

    public function poista() {
        $kysely = DB::connection()->prepare('DELETE FROM TehtavanLuokka WHERE luokkaid = :luokkaid');
        $kysely->execute(array('luokkaid' => $this->id));
        $rivi = $kysely->fetch();
        $kysely = DB::connection()->prepare('DELETE FROM Luokka WHERE id = :id');
        $kysely->execute(array('id' => $this->id));
        $rivi = $kysely->fetch();
    }

}