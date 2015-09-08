<?php
    
  //require 'app/models/Aanestys.php';
  class HelloWorldController extends BaseController{

    //public static function index(){}

    public static function sandbox(){
        //View::make('helloworld.html');
        $tiedot = Aanestys::haeYksi('1');
        $aanestykset = Aanestys::haeKaikki();
        $ehdokkaat = Ehdokkaat::haeKaikkiEhdokkaat('1');
        $aanestykset = Kayttaja::omatAanestykset('1');
        // Kint-luokan dump-metodi tulostaa muuttujan arvon
        Kint::dump($tiedot);
        Kint::dump($aanestykset);
        Kint::dump($ehdokkaat);
        Kint::dump($aanestykset);
    }
    
    /*public static function kaikki(){
      View::make('kaikki.html');
    }*/
    
    public static function tiedot(){
      View::make('tiedot.html');
    }
    
    public static function muokkaa(){
      View::make('muokkaa.html');
    }
    
    public static function luo(){
      View::make('luo.html');
    }
    
    
    
  }
