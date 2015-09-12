<?php

class Aanestaneet extends BaseModel{
    
    public $kayttaja_id, $aanestys_id, $ehdokas_id;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public function haeTiedot() {
        $query = DB::connection()->prepare('SELECT ehdokas_id FROM aanestaneet WHERE kayttaja_id = :kayttaja_id AND aanestys_id = :aanestys_id LIMIT 1');
        $query->execute(array('kayttaja_id' => $this->kayttaja_id, 'aanestys_id' => $this->aanestys_id));  
    
        $ehdokas = $query->fetch();
        $ehdokas = $ehdokas['0'];
        
        return $ehdokas;
    }
    
    public function aktiviteetti() {
        $query = DB::connection()->prepare('SELECT aanestys.id, aanestys.nimi, ehdokas.id, ehdokas.nimi, ehdokas.aania FROM aanestys, ehdokas, aanestaneet WHERE aanestys.id = aanestaneet.aanestys_id AND ehdokas.id = aanestaneet.ehdokas_id AND aanestaneet.kayttaja_id= :kayttaja_id ORDER BY aanestys.nimi ASC;');
        $query->execute(array('kayttaja_id' => $this->kayttaja_id));  
    
        $rivit = $query->fetchAll();
        
        $omat = array();
        
        foreach ($rivit as $rivi) {
            $omat[] = array(
               'aanestys_id' => $rivi['0'],
               'aanestys_nimi' => $rivi['1'],
               'ehdokas_id' => $rivi['2'],
               'ehdokas_nimi' => $rivi['3'],
               'ehdokas_aanet' => $rivi['4']
            );
            
        }
        
        return $omat;
    }
    
    
    
}