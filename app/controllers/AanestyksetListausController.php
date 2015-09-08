<?php


class AanestyksetListausController extends BaseController {
    
    public static function getKaikki() {
        $aanestykset = Aanestys::haeKaikki();
        sort($aanestykset);
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
        View::make('tiedot.html', array('aanestys' => $aanestys, 'kayttaja' => $kayttaja));
    }
    
    public static function getMuokkaa($id) {
        $kayttaja = self::onKirjautunut();
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
        
        $params = $_POST;
        
        $aanestys = new Aanestys(array(
            'luonut' => $params['luonut'],
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'paattyy' => $params['paattyy'],
            'kirjautuminen' => $params['kirjautuminen'],
            'ehdokkaat' => null
        ));
        
        $aanestys->tallenna();
        
        Redirect::to('/tiedot/' . $aanestys->id, array('viesti' => 'Äänestys luotu onnistuneesti!'));
        
    }
    
    public static function muokkaaAanestys($id) {
        
        $params = $_POST;
        
        $attributes = array(
            'id' => $id,
            'nimi' => $params['nimi'],
            'kuvaus' => $params['kuvaus'],
            'paattyy' => $params['paattyy'],
            'kirjautuminen' => $params['kirjautuminen'],
            
        );
        
        $aanestys = new Aanestys($attributes);
        
        $aanestys->paivita($id);
        
        Redirect::to('/tiedot/' . $id, array('viesti' => 'Muokattu onnistuneesti!'));
        
    }
    
    
    
}

