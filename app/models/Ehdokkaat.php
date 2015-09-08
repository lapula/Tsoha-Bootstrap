<?php

class Ehdokkaat extends BaseModel{
    
    public $id, $aanestys_id, $nimi, $aania;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function haeKaikkiEhdokkaat($aanestys_id) {
        $query = DB::connection()->prepare('SELECT * FROM ehdokas WHERE aanestys_id = :aanestys_id');
        
        $query->execute(array('aanestys_id' => $aanestys_id));
        $rivit = $query->fetchAll();
        $ehdokkaat = array();
        
        foreach ($rivit as $rivi) {
            $ehdokkaat[] = new Ehdokkaat(array(
               'id' => $rivi['id'],
               'aanestys_id' => $rivi['aanestys_id'],
               'nimi' => $rivi['nimi'],
               'aania' => $rivi['aania']
            ));
            
        }
        
        return $ehdokkaat;
    }
    
    public function tallenna() {
        
        $query = DB::connection()->prepare('INSERT INTO ehdokas (aanestys_id, nimi, aania) VALUES (:aanestys_id, :nimi, :aania) RETURNING id');
    
        $query->execute(array('aanestys_id' => $this->aanestys_id, 'nimi' => $this->nimi, 'aania' => $this->aania));
        
        $rivi = $query->fetch();
        
        $this->id = $rivi['id'];
    }
    
    public function poista($id) {
        
        
        $query = DB::connection()->prepare('DELETE FROM aanestaneet WHERE ehdokas_id = :id');
        $query->execute(array('id' => $id));
        
        $query = DB::connection()->prepare('DELETE FROM ehdokas WHERE id = :id');
        $query->execute(array('id' => $id));
        

        
    }
    
    public function aanestaKirjautumatta($id) {
        $query = DB::connection()->prepare('UPDATE ehdokas SET aania = aania+1 WHERE id = :id');
        $query->execute(array('id' => $id));
    }
    
    public function aanestaKirjautuneena($kayttaja_id, $aanestys_id, $ehdokas_id) {
        $query = DB::connection()->prepare('UPDATE ehdokas SET aania = aania+1 WHERE id = :id');
        $query->execute(array('id' => $ehdokas_id));
        
        $query = DB::connection()->prepare('INSERT INTO aanestaneet (kayttaja_id, aanestys_id, ehdokas_id) VALUES (:kayttaja_id, :aanestys_id, :ehdokas_id)');
        $query->execute(array('kayttaja_id' => $kayttaja_id, 'aanestys_id' => $aanestys_id, 'ehdokas_id' => $ehdokas_id));
    }
    
    
}
