<?php

require 'app/models/luokka.php';

class HelloWorldController extends BaseController {

    public static function index() {
// make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('suunnitelmat/kirjautuminen.html');
    }

    public static function sandbox() {
// Testaa koodiasi täällä
       // View::make('helloworld.html');
        $tyyppi = Kayttaja::find(1);
        $kayttajat = Kayttaja::all();
// Kint-luokan dump-metodi tulostaa muuttujan arvon
        Kint::dump($kayttajat);
        Kint::dump($tyyppi);
    }

    public static function muistilista() {
        View::make('suunnitelmat/muistilista.html');
    }

    public static function muokkaa() {
        View::make('suunnitelmat/muokkaa.html');
    }

    public static function kirjaudu() {
        View::make('suunnitelmat/kirjautuminen.html');
    }

    public static function kuvaus() {
        View::make('suunnitelmat/kuvaus.html');
    }

}
