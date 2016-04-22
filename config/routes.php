<?php

function check_logged_in() {
    BaseController::check_logged_in();
}

$routes->get('/', 'check_logged_in', function() {
    KayttajaController::kirjautuminen();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/suunnitelmat/muistilista', function() {
    HelloWorldController::muistilista();
});
$routes->get('/suunnitelmat/muokkaa/1', function() {
    HelloWorldController::muokkaa();
});
$routes->get('/suunnitelmat/kirjautuminen', function() {
    HelloWorldController::kirjaudu();
});
$routes->get('/suunnitelmat/kuvaus/1', function() {
    HelloWorldController::kuvaus();
});

$routes->get('/tehtavat', 'check_logged_in', function() {
    TehtavaController::index();
});
$routes->post('/tehtava', 'check_logged_in', function() {
    TehtavaController::store();
});
$routes->get('/tehtava/uusi', 'check_logged_in', function() {
    TehtavaController::uusi();
});
$routes->get('/tehtava/:id', 'check_logged_in', function($id) {
    TehtavaController::show($id);
});
$routes->get('/tehtava/:id/muokkaa', 'check_logged_in', function($id) {
    TehtavaController::muokkaa($id);
});
$routes->post('/tehtava/:id/muokkaa', 'check_logged_in', function($id) {
    TehtavaController::paivita($id);
});
$routes->post('/tehtava/:id/poista', 'check_logged_in', function($id) {
    TehtavaController::poista($id);
});

$routes->get('/kirjautuminen', function() {
    KayttajaController::kirjautuminen();
});
$routes->post('/kirjautuminen', function() {
    KayttajaController::kasittele_kirjautuminen();
});
$routes->post('/kirjaudu_ulos', function() {
    KayttajaController::kirjaudu_ulos();
});

$routes->get('/luokat', 'check_logged_in', function() {
    LuokkaController::index();
});
$routes->get('/luokka/uusi', 'check_logged_in', function() {
    LuokkaController::uusi();
});
$routes->get('/luokka/:id', 'check_logged_in', function($id) {
    LuokkaController::show($id);
});
$routes->post('/luokka', 'check_logged_in', function() {
    LuokkaController::store();
});
$routes->get('/luokka/:id/muokkaa', 'check_logged_in', function($id) {
    LuokkaController::muokkaa($id);
});
$routes->post('/luokka/:id/muokkaa', 'check_logged_in', function($id) {
    LuokkaController::paivita($id);
});
$routes->post('/luokka/:id/poista', 'check_logged_in', function($id) {
    LuokkaController::poista($id);
});

$routes->get('/rekisteroityminen', function() {
    KayttajaController::rekisteroityminen();
});
$routes->post('/rekisteroityminen', function() {
    KayttajaController::luo_uusi_kayttaja();
});
