<?php

class LuokkaController extends BaseController {

    public static function index() {
        $luokat = Luokka::all();
        View::make('luokka/index.html', array('luokat' => $luokat));
    }

    public static function show($id) {
        $luokka = Luokka::find($id);
        View::make('luokka/kuvaus.html', array('luokka' => $luokka));
    }

    public static function store() {
        $params = $_POST;
        $luokka = new Luokka(array(
            'nimi' => $params['nimi'],
            'kayttaja' => $_SESSION['kayttaja']
        ));
        $luokka->save();
        Redirect::to('luokka' . $luokka->id, array('viesti' => 'Luokkasi on lisätty'));
    }

    public static function uusi() {
        View::make('luokka/uusi.html');
    }

}
