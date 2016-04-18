<?php

class KayttajaController extends BaseController {

    public static function kirjautuminen() {
        View::make('kayttaja/kirjautuminen.html');
    }

    public static function kasittele_kirjautuminen() {
        $params = $_POST;
        $kayttaja = Kayttaja::tarkista($params['kayttajatunnus'], $params['salasana']);
        if ($kayttaja) {
            $_SESSION['kayttaja'] = $kayttaja->id;
            Redirect::to('/', array('viesti' => 'Tervetuloa ' . $kayttaja->kayttajatunnus));
        } else {
            $virheet = array('Väärä käyttäjätunnus tai salasana');
            View::make('kayttaja/kirjautuminen.html', array('virheet' => $virheet, 'kayttajatunnus' => $params['kayttajatunnus']));
        }
    }

}
