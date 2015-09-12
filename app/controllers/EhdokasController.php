<?php


class EhdokasController extends BaseController {
    
    public static function lisaaEhdokas($aanestys_id) {
        $kayttaja = self::onKirjautunut();
        $params = $_POST;
        
        $ehdokkaat = new Ehdokkaat(array(
               'aanestys_id' => $aanestys_id,
               'nimi' => $params['nimi'],
               'aania' => 0
            ));
        
        $virheet = $ehdokkaat->errors();
        
        if (count($virheet) == 0) {
            $ehdokkaat->tallenna();
            Redirect::to('/tiedot/' . $ehdokkaat->aanestys_id, array('viesti' => 'Ehdokas lisätty onnistuneesti!'));
        } else {
            $aanestys = Aanestys::haeYksi($aanestys_id);
            View::make('tiedot.html', array('aanestys' => $aanestys, 'kayttaja' => $kayttaja, 'virheet'=> $virheet));
        }
    }
    
    public static function poistaEhdokas($id, $ehdokas_id) {
        
        $ehdokas = new Ehdokkaat(array('ehdokas_id' => $ehdokas_id));
        
        $ehdokas->poista($ehdokas_id);
        Redirect::to('/tiedot/' . $id, array('viesti' => 'Ehdokas poistettu onnistuneesti!'));
        
    }
    
    public static function aanestaKirjautumatta($id, $ehdokas_id) {
        
        $ehdokas = new Ehdokkaat(array('id' => $ehdokas_id));
        
        if ($ehdokas->tarkistaAanestysKirjautumatta($id)) {
            $ehdokas->aanestaKirjautumatta($ehdokas_id);
            Redirect::to('/tiedot/' . $id, array('viesti' => 'Äänestit ehdokasta!'));
        } else {
            Redirect::to('/tiedot/' . $id, array('viesti' => 'Yritit huijata!'));
        }
        
    }
    
    public static function aanestaKirjautuneena($aanestys_id, $ehdokas_id) {
        $kayttaja = self::onKirjautunut();
        $ehdokas = new Ehdokkaat(array('kayttaja_id' => $kayttaja->id,'aanestys_id' => $aanestys_id, 'ehdokas_id' => $ehdokas_id));
        
        $onnistui = $ehdokas->aanestaKirjautuneena($kayttaja->id, $aanestys_id, $ehdokas_id);
        
        if ($onnistui) {
            Redirect::to('/tiedot/' . $aanestys_id, array('viesti' => 'Äänestit ehdokasta!'));
        } else {
            $aanestys = Aanestys::haeYksi($aanestys_id);
            View::make('tiedot.html', array('aanestys' => $aanestys, 'kayttaja' => $kayttaja, 'viesti' => 'Olet jo äänestänyt tätä ehdokasta!'));
        }
        
        
        
    }
    
    
}