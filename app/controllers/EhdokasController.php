<?php


class EhdokasController extends BaseController {
    
    public static function lisaaEhdokas($aanestys_id) {
        
        $params = $_POST;
        
        $ehdokkaat = new Ehdokkaat(array(
               'aanestys_id' => $aanestys_id,
               'nimi' => $params['nimi'],
               'aania' => 0
            ));
        
        $ehdokkaat->tallenna();
        
        Redirect::to('/tiedot/' . $ehdokkaat->aanestys_id, array('viesti' => 'Ehdokas lisätty onnistuneesti!'));
        
    }
    
    public static function poistaEhdokas($id, $ehdokas_id) {
        
        $ehdokas = new Ehdokkaat(array('ehdokas_id' => $ehdokas_id));
        
        $ehdokas->poista($ehdokas_id);
        Redirect::to('/tiedot/' . $id, array('viesti' => 'Ehdokas poistettu onnistuneesti!'));
        
    }
    
    public static function aanestaKirjautumatta($id, $ehdokas_id) {
        
        $ehdokas = new Ehdokkaat(array('id' => $ehdokas_id));
        
        $ehdokas->aanestaKirjautumatta($ehdokas_id);
        
        
        
        Redirect::to('/tiedot/' . $id, array('viesti' => 'Äänestit ehdokasta!'));
        
    }
    
    public static function aanestaKirjautuneena($aanestys_id, $ehdokas_id) {
        $kayttaja = self::onKirjautunut();
        $ehdokas = new Ehdokkaat(array('kayttaja_id' => $kayttaja->id,'aanestys_id' => $aanestys_id, 'ehdokas_id' => $ehdokas_id));
        
        $ehdokas->aanestaKirjautuneena($kayttaja->id, $aanestys_id, $ehdokas_id);
        
        
        
        Redirect::to('/tiedot/' . $aanestys_id, array('viesti' => 'Äänestit ehdokasta!'));
        
    }
    
}