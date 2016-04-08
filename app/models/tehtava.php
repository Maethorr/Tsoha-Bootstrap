<?php

class Tehtava extends BaseModel {

    public $id, $kayttajaId, $nimi, $kuvaus, $prioriteetti, $lisayspaiva;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tehtava');
        $query->execute();
        $rows = $query->fetchAll();
        $tehtavat = array();
        foreach ($rows as $row) {
            $tehtavat[] = new Tehtava(array(
                'id' => $row['id'],
                'kayttajaId' => $row['kayttajaId'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'prioriteetti' => $row['prioriteetti'],
                'lisayspaiva' => $row['lisayspaiva']
            ));
        }
        return $tehtavat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tehtava WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $tehtava = new Tehtava(array(
                'id' => $row['id'],
                'kayttajaId' => $row['kayttajaId'],
                'nimi' => $row['nimi'],
                'kuvaus' => $row['kuvaus'],
                'prioriteetti' => $row['prioriteetti'],
                'lisayspaiva' => $row['lisayspaiva']
            ));
            return $tehtava;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tehtava (nimi, kuvaus, prioriteetti, lisayspaiva) VALUES (:kayttajaId, :nimi, :kuvaus, :prioriteetti, :lisayspaiva) RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'prioriteetti' => $this->prioriteetti, 'lisayspaiva' => $this->lisayspaiva));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
