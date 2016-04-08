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
        $tehtava = new Tehtava(array(
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'prioriteetti' => (int) $params['prioriteetti'],
            'lisayspaiva' => $params['lisayspaiva']
        ));
        $tehtava->save();
        Redirect::to('/tehtava/' . $tehtava->id, array('viesti' => 'Tehtäväsi on lisätty'));
    }

    public static function uusi() {
        //$luokat = Luokka::all();
        View::make('tehtava/uusi.html');
    }

}
