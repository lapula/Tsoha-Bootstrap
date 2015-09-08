<?php


class KayttajaController extends BaseController {
    
    public static function getKaikki(){
      $kayttaja = self::onKirjautunut();
      $kayttajat = Kayttaja::haeKaikki();
      View::make('/kayttaja/kaikki.html', array('kayttajat' => $kayttajat,'kayttaja' => $kayttaja));
    }
    
    public static function getKirjaudu(){
      $kayttaja = self::onKirjautunut();
      View::make('/kayttaja/kirjaudu.html', array('kayttaja' => $kayttaja));
    }
    
    public static function uusikayttaja(){
      $kayttaja = self::onKirjautunut();
      View::make('/kayttaja/uusikayttaja.html', array('kayttaja' => $kayttaja));
    }
    
    public static function luoUusikayttaja(){
        $params = $_POST;
        
        $attributes = (array(
               'nimi' => $params['nimi'],
               'salasana' => $params['salasana']
            ));
        $kayttaja = new Kayttaja($attributes);
        
        $virheet = $kayttaja->errors();
        
        if (count($virheet) == 0) {
            $kayttaja->tallenna();
            Redirect::to('/kayttaja/kirjaudu', array('virhe' => 'Käyttäjä luotu! Kirjaudu sisään :)'));
        } else {
            View::make('/kayttaja/uusikayttaja.html', array('virheet' => $virheet, 'attributes' => $attributes));
        }
        
        
        
        
    }
    
    public static function poistaKayttaja($id) {
        $kayttaja = new Kayttaja(array('id' => $id));
        $_SESSION['kayttaja'] = null;
        $kayttaja->poista($id);
        Redirect::to('/kaikki', array('viesti' => 'Käyttäjä poistettu onnistuneesti!'));
    }
    
    public static function kirjaudu() {
        $params = $_POST;
        
        $kayttaja = Kayttaja::validoi($params['nimi'], $params['salasana']);
        
        if (!$kayttaja) {
            View::make('/kayttaja/kirjaudu.html', array('virhe' => 'Väärä käyttäjätunnus tai salasana!'));
        } else {
            $_SESSION['kayttaja'] = $kayttaja->id;
        }
        
        Redirect::to('/', array('viesti' => 'Tervetuloa ' . $kayttaja->nimi . '!'));
    }
    
    public static function kirjauduUlos(){
      $_SESSION['kayttaja'] = null;
      Redirect::to('/kayttaja/kirjaudu', array('virhe' => 'Olet kirjautunut ulos!'));
    }
    
    public static function getMuokkaa(){
      $kayttaja = self::onKirjautunut();
      View::make('/kayttaja/muokkaa.html', array('kayttaja' => $kayttaja));
    }
    
    public static function muokkaa($id){
      $params = $_POST;
      $kayttaja = self::onKirjautunut();
        
        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'salasana' => $params['salasana'],           
        );
        
        $muokattukayttaja = new Kayttaja($attributes);
        
        $virheet = $muokattukayttaja->errors();
        
        if (count($virheet) == 0 || 
                (count($virheet) == 1 && $virheet[0] ==  'Nimi on jo käytössä!'
                 && $params['nimi'] == $kayttaja->nimi)) {
            $muokattukayttaja->muokkaa($id);
            Redirect::to('/', array('viesti' => 'Käyttäjätiedot muokattu onnistuneesti!'));
        } else {
            View::make('/kayttaja/muokkaa.html', array('virheet' => $virheet, 'kayttaja' => $kayttaja));
        }
    }
    
    public static function omatAanestykset($id){
      $kayttaja = self::onKirjautunut();
      $aanestykset = Kayttaja::omatAanestykset($id);
      View::make('/kayttaja/omataanestykset.html', array('aanestykset' => $aanestykset,'kayttaja' => $kayttaja));
    }
    
    
    
}