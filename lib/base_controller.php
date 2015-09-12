<?php

  class BaseController{

    public static function onKirjautunut(){
      if(isset($_SESSION['kayttaja'])){
        $kayttaja_id = $_SESSION['kayttaja'];
      
        $kayttaja = Kayttaja::haeYksi($kayttaja_id);

        return $kayttaja;
      }

    return null;
    }

    public static function tarkistaKirjautuminen(){
      if(!isset($_SESSION['kayttaja'])){
          Redirect::to('/kayttaja/kirjaudu', array('virhe' => 'Kirjaudu ensin sisään!'));
      }
    }
    
    

  }
