<?php

class Luokka extends BaseModel {

    public $id, $kayttajaId, $nimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $kysely = DB::connection()->prepare('SELECT * FROM Luokka');
        $kysely->execute();
        $rivit = $kysely->fetchAll();
        $luokat = array();

        foreach ($rivit as $rivit) {
            $luokat[] = new Luokka(array(
                'id' => $rivi['id'],
                'kayttajaId' => $rivi['kayttajaId'],
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
                'kayttajaId' => $rivi['kayttajaId'],
                'nimi' => $rivi['nimi']
            ));
        }
        
        return $luokka;
    }
    
    public function save() {
        $kysely = DB::connection()->prepare('INSERT INTO Luokka (kayttajaId, nimi) VALUES (:kayttajaId, :nimi) RETURNING id');
        $kysely->execute(array('kayttajaId' => $this->kayttajaId, 'nimi' => $this->nimi));
        $rivi = $kysely->fetch();
        $this->id = $rivi['id'];
    }

}
