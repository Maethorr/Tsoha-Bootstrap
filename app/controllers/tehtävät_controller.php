<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TehtäväController extends BaseController {
    public static function index() {
        $tehtävät = Tehtävä::all();
        View::make('suunnitelmat/muistilista.html', array('tehtävät' => $tehtävät));
    }
    public static function store() {
        $params = $_POST;
        $tehtävä = new Tehtävä(array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'prioriteetti' => $params['prioriteetti'],
            'luokka' => $params['luokka']
        ));
        $tehtävä->save();
        Redirect::to('/suunnitelmat/' . $tehtävä->id, array('message' => 'Tehtävä on lisätty listaasi!'));
    }
    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tehtävä (nimi, prioriteetti, luokka, kuvaus) VALUES (:nimi, :prioriteetti, :luokka, :kuvaus) RETURNING id');
        $query->execute(array('nimi' => $this->nimi, 'prioriteetti' => $this->prioriteetti, 'luokka' => $this->luokka, 'kuvaus' => $this->kuvaus));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
}

