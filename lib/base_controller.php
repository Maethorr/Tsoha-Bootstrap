<?php

class BaseController {

    public static function get_user_logged_in() {
        // Toteuta kirjautuneen käyttäjän haku tähän
        if (isset($_SESSION['kayttajaid'])) {
            $kayttaja_id = $_SESSION['kayttajaid'];
            $kayttaja = Kayttaja::find($kayttaja_id);
            return $kayttaja;
        } else {
            return null;
        }
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['kayttajaid'])) {
            Redirect::to('/kirjautuminen', array('virheet' => array('Sinun täytyy kirjautua sisään!')));
        }
    }

}
