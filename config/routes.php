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

$routes->get('/luokat', function() {
    LuokkaController::index();
});

