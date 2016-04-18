<?php

$routes->get('/', function() {
    TehtavaController::index();
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

$routes->get('/tehtavat', function() {
    TehtavaController::index();
});
$routes->post('/tehtava', function() {
    TehtavaController::store();
});
$routes->get('/tehtava/uusi', function() {
    TehtavaController::uusi();
});
$routes->get('/tehtava/:id', function($id) {
    TehtavaController::show($id);
});
$routes->get('/tehtava/:id/muokkaa', function($id) {
    TehtavaController::muokkaa($id);
});
$routes->post('/tehtava/:id/muokkaa', function($id) {
    TehtavaController::paivita($id);
});
$routes->post('/tehtava/:id/poista', function($id) {
    TehtavaController::poista($id);
});

$routes->get('/kirjautuminen', function() {
    KayttajaController::kirjautuminen();
});
$routes->post('/kirjautuminen', function() {
    KayttajaController::kasittele_kirjautuminen();
});

$routes->get('/luokat', function() {
    LuokkaController::index();
});
$routes->get('/luokka/uusi', function() {
    LuokkaController::uusi();
});
$routes->get('/luokka/:id', function($id) {
    LuokkaController::show($id);
});
$routes->post('/luokka', function() {
    LuokkaController::store();
});
$routes->get('/luokka/:id/muokkaa', function($id) {
    LuokkaController::muokkaa($id);
});
$routes->post('/luokka/:id/muokkaa', function($id) {
    LuokkaController::paivita($id);
});
$routes->post('/luokka/:id/poista', function($id) {
    LuokkaController::poista($id);
});
