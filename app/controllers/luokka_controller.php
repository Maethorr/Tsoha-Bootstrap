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
        $parametrit = array(
            'nimi' => $params['nimi'],
            'kayttajaid' => $_SESSION['kayttajaid']
        );
        $luokka = new Luokka($parametrit);
        $virheet = $luokka->errors();
        if (count($virheet) == 0) {
            $luokka->save();
            Redirect::to('/luokka/' . $luokka->id, array('viesti' => 'Luokkasi on lisätty'));
        } else {
            View::make('luokka/uusi.html', array('virheet' => $virheet, 'parametrit' => $parametrit));
        }
    }

    public static function uusi() {
        View::make('luokka/uusi.html');
    }

    public static function muokkaa($id) {
        $luokka = Luokka::find($id);
        View::make('luokka/muokkaa.html', array('luokka' => $luokka));
    }

    public static function paivita($id) {
        $params = $_POST;
        $parametrit = array(
            'id' => $id,
            'kayttajaid' => $_SESSION['kayttajaid'],
            'nimi' => $params['nimi']
        );
        $luokka = new Luokka($parametrit);
        $virheet = $luokka->errors();
        if (count($virheet) == 0) {
            $luokka->paivita();
            Redirect::to('/luokka/' . $luokka->id, array('viesti' => 'Muutokset on tallennettu'));
        } else {
            View::make('luokka/muokkaa.html', array('virheet' => $virheet, 'luokka' => $luokka));
        }
    }

    public static function poista($id) {
        $luokka = new Luokka(array('id' => $id));
        $luokka->poista();
        Redirect::to('/luokat', array('viesti' => 'Luokka on poistettu'));
    }

}
