<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Käyttäjä extends BaseModel {
    public $id, $nimi, $käyttäjätyyppi, $käyttäjätunnus, $salasana;
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Käyttäjä');
        $query->execute();
        $rows = $query->fetchAll();
        $käyttäjät = array();
        foreach ($rows as $row) {
            $käyttäjät[] = new Käyttäjä(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'käyttäjätyyppi' => $row['käyttäjätyyppi'],
                'käyttäjätunnus' => $row['käyttäjätunnus'],
                'salasana' => $row['salasana']
                
            ));
        }
        return $käyttäjät;
    }
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Käyttäjä WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        if ($row) {
            $käyttäjä = new Käyttäjä(array(
                'id' => $row['id'],
                'nimi' => $row['nimi'],
                'käyttäjätyyppi' => $row['käyttäjätyyppi'],
                'käyttäjätunnus' => $row['käyttäjätunnus'],
                'salasana' => $row['salasana']
            ));
            return $käyttäjä;
        }
        return null;
    }
}

