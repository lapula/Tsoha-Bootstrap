<?php

class AanestaneetController extends BaseController {
    
    public static function getAktiviteetti() {
        $kayttaja = self::onKirjautunut();
        
        $aanestaneet = new Aanestaneet(array('kayttaja_id' => $kayttaja->id));
        $aktiviteetti = $aanestaneet->aktiviteetti();
        
        View::make('kayttaja/aktiviteetti.html', array('aktiviteetti' => $aktiviteetti, 'kayttaja' => $kayttaja));
    }
    
    
    
    
    
}