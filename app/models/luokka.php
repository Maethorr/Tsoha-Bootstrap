<?php

class Luokka extends BaseModel {

    public $id, $kayttajaid, $nimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $kysely = DB::connection()->prepare('SELECT * FROM Luokka');
        $kysely->execute();
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

}
