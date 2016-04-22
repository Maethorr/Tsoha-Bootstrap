<?php

class KayttajaController extends BaseController {

    public static function kirjautuminen() {
        View::make('kayttaja/kirjautuminen.html');
    }

    public static function kasittele_kirjautuminen() {
        $params = $_POST;
        $kayttaja = Kayttaja::tarkista($params['kayttajatunnus'], $params['salasana']);
        if ($kayttaja) {
            $_SESSION['kayttajaid'] = $kayttaja->id;
            Redirect::to('/tehtavat', array('viesti' => 'Tervetuloa ' . $kayttaja->kayttajatunnus));
        } else {
            $virheet = array('Väärä käyttäjätunnus tai salasana');
            View::make('kayttaja/kirjautuminen.html', array('virheet' => $virheet, 'kayttajatunnus' => $params['kayttajatunnus']));
        }
    }

    public static function rekisteroityminen() {
        View::make('kayttaja/rekisteroityminen.html');
    }

    public static function kirjaudu_ulos() {
        $_SESSION['kayttajaid'] = null;
        Redirect::to('/kirjautuminen', array('viesti' => 'Olet kirjautunut ulos'));
    }

    public static function luo_uusi_kayttaja() {
        $params = $_POST;
        $virheet = Kayttaja::luo_uusi_kayttaja($params['kayttajatunnus'], $params['salasana']);
        if ($virheet) {
            View::make('/kayttaja/rekisteroityminen.html', array('virheet' => $virheet));
        } else {
            Redirect::to('/kirjautuminen', array('viesti' => 'Uusi käyttäjätunnus on luotu'));
        }
    }

}
