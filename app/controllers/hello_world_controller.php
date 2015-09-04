<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
      View::make('helloworld.html');
    }
    
    public static function kaikki(){
      View::make('kaikki.html');
    }
    
    public static function tiedot(){
      View::make('tiedot.html');
    }
    
    public static function muokkaa(){
      View::make('muokkaa.html');
    }
    
    public static function luo(){
      View::make('luo.html');
    }
    
    public static function kirjaudu(){
      View::make('/kayttaja/kirjaudu.html');
    }
    
    public static function uusikayttaja(){
      View::make('/kayttaja/uusikayttaja.html');
    }
    
  }
