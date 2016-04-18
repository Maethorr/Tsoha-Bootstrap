<?php

class BaseController {

    public static function get_user_logged_in() {
        // Toteuta kirjautuneen käyttäjän haku tähän
        if (isset($_SESSION['kayttaja'])) {
            $kayttaja_id = $_SESSION['kayttajaid'];
            $kayttaja = Kayttaja::find($kayttaja_id);
            return $kayttaja;
        } else {
            return null;
        }
    }

    public static function check_logged_in() {
        // Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

}
