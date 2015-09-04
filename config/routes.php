<?php

  $routes->get('/', function() {
    //HelloWorldController::index();
      View::make('kaikki.html');
  });

  $routes->get('/hiekkalaatikko', function() {
    View::make('helloworld.html');
  });
  
  $routes->get('/kaikki', function() {
    View::make('kaikki.html');
  });
  
  $routes->get('/tiedot', function() {
    View::make('tiedot.html');
  });
  
  $routes->get('/muokkaa', function() {
    View::make('muokkaa.html');
  });
  
  $routes->get('/luo', function() {
    View::make('luo.html');
  });
  
  $routes->get('/kayttaja/kirjaudu', function() {
    View::make('kayttaja/kirjaudu.html');
  });
  
  $routes->get('/kayttaja/uusikayttaja', function() {
    View::make('kayttaja/uusikayttaja.html');
  });
