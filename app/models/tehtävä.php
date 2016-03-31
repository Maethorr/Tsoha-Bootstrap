<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tehtävä extends BaseModel {

    public $id, $käyttäjä_id, $luokka_id, $nimi, $prioriteetti, $status, $kuvaus;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Tehtävä');
        $query->execute();
        $rows = $query->fetchAll();
        $tehtävät = array();
        foreach ($rows as $row) {
            $tehtävät[] = new Tehtävä(array(
                'id' => $row['id'],
                'käyttäjä_id' => $row['käyttäjä_id'],
                'luokka_id' => $row['luokka_id'],
                'nimi' => $row['nimi'],
                'prioriteetti' => $row['prioriteetti'],
                'status' => $row['status'],
                'kuvaus' => $row['kuvaus']
            ));
        }
        return $tehtävät;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Tehtävä WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $tehtävä = new Tehtävä(array(
                'id' => $row['id'],
                'käyttäjä_id' => $row['käyttäjä_id'],
                'luokka_id' => $row['luokka_id'],
                'nimi' => $row['nimi'],
                'prioriteetti' => $row['prioriteetti'],
                'status' => $row['status'],
                'kuvaus' => $row['kuvaus']
            ));
            return $tehtävä;
        }
        return null;
    }

}
