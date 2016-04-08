<?php

class TehtavaController extends BaseController {

    public static function index() {
        $tehtavat = Tehtava::all();
        View::make('tehtava/index.html', array('tehtavat' => $tehtavat));
    }

    public static function show($id) {
        $tehtava = Tehtava::find($id);
        View::make('tehtava/kuvaus.html', array('tehtava' => $tehtava));
    }

    public static function store() {
        $params = $_POST;
        $luokat = $params['luokat'];
        $parametrit = array(
            'nimi' => $params['nimi'],
            'lisatiedot' => $params['lisatiedot'],
            'prioriteetti' => (int) $params['prioriteetti'],
            'kayttaja' => $_SESSION['kayttaja'],
            'luokat' => array()
        );
        foreach ($luokat as $luokka) {
            $parametrit['luokat'][] = $luokka;
        }
        $tehtava = new Tehtava($parametrit);
        $tehtava->save();
        Redirect::to('/tehtava/' . $tehtava->id, array('viesti' => 'Tehtäväsi on lisätty'));
    }

    public static function uusi() {
        $luokat = Luokka::all();
        View::make('tehtava/uusi.html', array('luokat' => $luokat));
    }

}
