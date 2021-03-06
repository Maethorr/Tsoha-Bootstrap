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
        $tehtava;
        $parametrit = array(
            'kayttajaid' => $_SESSION['kayttajaid'],
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'prioriteetti' => (int) $params['prioriteetti'],
            'luokat' => array()
        );
        if (isset($params['luokat'])) {
            $luokat = $params['luokat'];

            $kaikki_luokat = array();
            foreach ($luokat as $id) {
                $kaikki_luokat[] = new Luokka(array(
                    'id' => $id
                ));
            }
            $parametrit['luokat'] = $kaikki_luokat;
        }

        $tehtava = new Tehtava($parametrit);
        $virheet = $tehtava->errors();
        if (count($virheet) == 0) {
            $tehtava->save();
            Redirect::to('/tehtava/' . $tehtava->id, array('viesti' => 'Tehtäväsi on lisätty'));
        } else {
            $luokat = Luokka::all();
            $valitut = $tehtava->luokat;
            View::make('tehtava/uusi.html', array('virheet' => $virheet, 'parametrit' => $parametrit, 'luokat' => $luokat, 'valitut' => $valitut));
        }
    }

    public static function uusi() {
        $luokat = Luokka::all();
        View::make('tehtava/uusi.html', array('luokat' => $luokat));
    }

    public static function muokkaa($id) {
        $tehtava = Tehtava::find($id);
        $luokat = Luokka::all();
        $tehtavan_luokat = array();
        foreach ($tehtava->luokat as $luokka) {
            $tehtavan_luokat[] = new Luokka(array(
                'id' => $id
            ));
        }
        View::make('tehtava/muokkaa.html', array('tehtava' => $tehtava, 'luokat' => $luokat, 'tehtavan_luokat' => $tehtavan_luokat));
    }

    public static function paivita($id) {
        $params = $_POST;
        $tehtava;
        $parametrit = array(
            'id' => $id,
            'kayttajaid' => $_SESSION['kayttajaid'],
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'prioriteetti' => $params['prioriteetti'],
            'luokat' => array()
        );
        if (isset($params['luokat'])) {
            $luokat = $params['luokat'];
            $tehtavan_luokat = array();
            foreach ($luokat as $id) {
                $tehtavan_luokat[] = new Luokka(array(
                    'id' => $id
                ));
            }
            $parametrit['luokat'] = $tehtavan_luokat;
        }

        $tehtava = new Tehtava($parametrit);
        $virheet = $tehtava->errors();
        if (count($virheet) == 0) {
            $tehtava->paivita();
            Redirect::to('/tehtava/' . $tehtava->id, array('viesti' => 'Muutokset on tallennettu'));
        } else {
            $luokat = Luokka::all();
            $tehtavan_luokat = array();
            foreach ($luokat as $id) {
                $tehtavan_luokat[] = new Luokka(array(
                    'id' => $id
                ));
            }
            $parametrit['luokat'] = $tehtavan_luokat;
            View::make('tehtava/muokkaa.html', array('virheet' => $virheet, 'tehtava' => $tehtava, 'luokat' => $luokat, 'tehtavan_luokat' => $tehtavan_luokat));
        }
    }

    public static function poista($id) {
        $tehtava = new Tehtava(array('id' => $id));
        $tehtava->poista();
        Redirect::to('/tehtavat', array('viesti' => 'Tehtävä on poistettu'));
    }

}
