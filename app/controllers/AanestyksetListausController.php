<?php


class AanestyksetListausController extends BaseController {
    
    public static function getKaikki() {
        $aanestykset = Aanestys::haeKaikki();
        
        $kayttaja = self::onKirjautunut();
        View::make('kaikki.html', array('aanestykset' => $aanestykset, 'kayttaja' => $kayttaja));
    }
    
    public static function getLuo() {
        $kayttaja = self::onKirjautunut();
        View::make('luo.html', array('kayttaja' => $kayttaja));
    }
    
    public static function getTiedot($id) {
        $kayttaja = self::onKirjautunut();
        $aanestys = Aanestys::haeYksi($id);
        if ($kayttaja) {
            $aanestaneet = new Aanestaneet(array('kayttaja_id' => $kayttaja->id, 'aanestys_id' => $aanestys->id));
            $omaehdokas = $aanestaneet->haeTiedot();
        } else {
            $omaehdokas = null;
        }
        
        View::make('tiedot.html', array('aanestys' => $aanestys, 'kayttaja' => $kayttaja, 'omaehdokas' => $omaehdokas));
    }
    
    public static function getMuokkaa($id) {
        $kayttaja = self::onKirjautunut();
        
        if (!Aanestys::tarkistaOikeudet($id, $kayttaja->id)) {
            $aanestykset = Aanestys::haeKaikki();
            View::make('kaikki.html', array('aanestykset' => $aanestykset, 'kayttaja' => $kayttaja, 'viesti' => 'Yritit päästä käsiksi muiden tietoihin!'));
        }
        
        $aanestys = Aanestys::haeYksi($id);
        View::make('muokkaa.html', array('aanestys' => $aanestys, 'kayttaja' => $kayttaja));
    }
    
    public static function getPoista($id) {
        $kayttaja = self::onKirjautunut();
        $aanestys = Aanestys::haeYksi($id);
        View::make('poista.html', array('aanestys' => $aanestys, 'kayttaja' => $kayttaja));
    }
    
    public static function poistaAanestys($id) {
        $aanestys = new Aanestys(array('id' => $id));
        $aanestys->poista($id);
        Redirect::to('/kaikki', array('viesti' => 'Äänestys poistettu onnistuneesti!'));
    }
    
    public static function luoAanestys() {
        $kayttaja = self::onKirjautunut();
        $params = $_POST;
        
        $attributes = (array(
            'luonut' => $params['luonut'],
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'paattyy' => $params['paattyy'],
            'kirjautuminen' => $params['kirjautuminen'],
            'ehdokkaat' => null
        ));
        
        $aanestys = new Aanestys($attributes);
        $virheet = $aanestys->errors();
        
        if (count($virheet) == 0) {
            $aanestys->tallenna();
            Redirect::to('/tiedot/' . $aanestys->id, array('viesti' => 'Äänestys luotu onnistuneesti!'));
        } else {
            View::make('/luo.html', array('virheet' => $virheet, 'attributes' => $attributes, 'kayttaja' => $kayttaja));
        }
        
        
        
    }
    
    public static function muokkaaAanestys($id) {
        $kayttaja = self::onKirjautunut();
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'paattyy' => $params['paattyy'],
            'kirjautuminen' => $params['kirjautuminen'],
            
        );
        
        $aanestys = new Aanestys($attributes);
        $virheet = $aanestys->errors();
        
        
        
        if (count($virheet) == 0) {
            $aanestys->paivita($id);
            Redirect::to('/tiedot/' . $id, array('viesti' => 'Muokattu onnistuneesti!'));
        } else {
            View::make('/muokkaa.html', array('virheet' => $virheet, 'kayttaja' => $kayttaja, 'aanestys' => $aanestys));
        }
        
        
        
    }
    
    
    
}

