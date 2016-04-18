<?php

class Kayttaja extends BaseModel {

    public $id, $kayttajatunnus, $salasana;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function tarkista($kayttajatunnus, $salasana) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kayttajatunnus = :kayttajatunnus and salasana = :salasana LIMIT 1');
        $kysely->execute(array('kayttajatunnus' => $kayttajatunnus, 'salasana' => $salasana));
        $rivi = $kysely->fetch();
        if($rivi) {
          return new Kayttaja(array(
            'id' => $rivi['id'],
            'kayttajatunnus' => $rivi['kayttajatunnus'],
            'salasana' => $rivi['salasana']
          ));
        } else {
          return null;
        }
      }

    public static function find($id) {
        $kysely = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE id = :id LIMIT 1');
        $kysely->execute(array('id' => $id));
        $rivi = $kysely->fetch();

        if ($rivi) {
            $kayttaja = new Kayttaja(array(
                'id' => $rivi['id'],
                'kayttajatunnus' => $rivi['kayttajatunnus'],
                'salasana' => $rivi['salasana']
            ));

            return $kayttaja;
        }

        return null;
    }

    public function save() {
        $kysely = DB::connection()->prepare('INSERT INTO Kayttaja (kayttajanimi, salsana) VALUES (:kayttajanimi, :salasana) RETURNING id');
        $kysely->execute(array('kayttajanimi' => $this->kayttajanimi, 'salsana' => $this->salsana));
        $rivi = $kysely->fetch();
        $this->id = $rivi['id'];
    }

}
