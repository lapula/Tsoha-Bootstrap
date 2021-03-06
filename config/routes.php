<?php

  function tarkistaKirjautuminen() {
      BaseController::tarkistaKirjautuminen();
  }

  $routes->get('/', function() {
      AanestyksetListausController::getKaikki();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/kaikki', function() {
      AanestyksetListausController::getKaikki();
  });
  
  $routes->get('/tiedot/:id', function($id) {
      AanestyksetListausController::getTiedot($id);
  });
  
  $routes->get('/muokkaa/:id', 'tarkistaKirjautuminen', function($id) {
      AanestyksetListausController::getMuokkaa($id);
  });
  
  $routes->post('/muokkaa/:id', 'tarkistaKirjautuminen', function($id) {
      AanestyksetListausController::muokkaaAanestys($id);
  });
  
  $routes->get('/poista/:id', 'tarkistaKirjautuminen', function($id) {
      AanestyksetListausController::getPoista($id);
  });
  
  $routes->post('/poista/:id', 'tarkistaKirjautuminen', function($id) {
      AanestyksetListausController::poistaAanestys($id);
  });
  
  $routes->get('/luo', 'tarkistaKirjautuminen', function() {
      AanestyksetListausController::getLuo();
  });
  
  $routes->post('/luo', 'tarkistaKirjautuminen', function() {
      AanestyksetListausController::luoAanestys();
  });
  
  $routes->get('/kayttaja/kaikki', function() {
     KayttajaController::getKaikki();
  });
  
  $routes->get('/kayttaja/kirjaudu', function() {
     KayttajaController::getKirjaudu();
  });
  
  $routes->post('/kayttaja/kirjaudu', function() {
     KayttajaController::kirjaudu();
  });
  
  $routes->get('/kayttaja/kirjauduUlos', 'tarkistaKirjautuminen', function() {
     KayttajaController::kirjauduUlos();
  });
  
  $routes->get('/kayttaja/muokkaa', 'tarkistaKirjautuminen',  function() {
     KayttajaController::getMuokkaa();
  });
  
  $routes->post('/kayttaja/muokkaa/:id', 'tarkistaKirjautuminen',  function($id) {
     KayttajaController::muokkaa($id);
  });
  
  $routes->get('/kayttaja/uusikayttaja', function() {
    KayttajaController::uusikayttaja();
  });
  
  $routes->post('/kayttaja/uusikayttaja', function() {
    KayttajaController::luoUusikayttaja();
  });
  
  $routes->get('/kayttaja/poista/:id', 'tarkistaKirjautuminen',  function($id) {
    KayttajaController::poistaKayttaja($id);
  });
  
  $routes->get('/kayttaja/omataanestykset', 'tarkistaKirjautuminen',  function() {
    KayttajaController::omatAanestykset();
  });
  
  $routes->get('/poistaehdokas/:id/:ehdokas_id', 'tarkistaKirjautuminen',  function($id, $ehdokas_id) {
      EhdokasController::poistaEhdokas($id, $ehdokas_id);
  });
  
  $routes->post('/tiedot/:id', 'tarkistaKirjautuminen',  function($id) {
      EhdokasController::lisaaEhdokas($id);
  });
  
  $routes->get('/aanestakirjautumatta/:id/:ehdokas_id', function($id, $ehdokas_id) {
      EhdokasController::aanestaKirjautumatta($id, $ehdokas_id);
  });
  
  $routes->get('/aanestakirjautuneena/:id/:ehdokas_id', 'tarkistaKirjautuminen',  function($id, $ehdokas_id) {
      EhdokasController::aanestaKirjautuneena($id, $ehdokas_id);
  });
  
  $routes->get('/kayttaja/aktiviteetti', 'tarkistaKirjautuminen', function() {
      AanestaneetController::getAktiviteetti();
  });
