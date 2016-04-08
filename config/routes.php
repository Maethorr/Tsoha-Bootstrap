<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/kirjautuminen', function() {
    HelloWorldController::kirjaudu();
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
