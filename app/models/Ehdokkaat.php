<?php

class Ehdokkaat extends BaseModel {
    
    public $id, $aanestys_id, $nimi, $aania;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validointi = array('validoiNimi');
    }
    
    public static function haeKaikkiEhdokkaat($aanestys_id) {
        $query = DB::connection()->prepare('SELECT * FROM ehdokas WHERE aanestys_id = :aanestys_id ORDER BY ehdokas.aania DESC, ehdokas.nimi ASC');
        
        $query->execute(array('aanestys_id' => $aanestys_id));
        $rivit = $query->fetchAll();
        $ehdokkaat = array();
        
        $aanet = array();
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
    
    public function tarkistaAanestysKirjautumatta($id) {
        $query = DB::connection()->prepare('SELECT aanestys.kirjautuminen FROM aanestys where id = :id');
        $query->execute(array('id' => $id));
        $rivi = $query->fetch();
        if ($rivi[0] == 1) {
            return false;
        } else {
            return true;
        }
    }
    
    public function aanestaKirjautuneena($kayttaja_id, $aanestys_id, $ehdokas_id) {
        
        $query = DB::connection()->prepare('SELECT * FROM aanestaneet WHERE kayttaja_id = :kayttaja_id AND aanestys_id = :aanestys_id AND ehdokas_id = :ehdokas_id LIMIT 1');
        $query->execute(array('kayttaja_id' => $kayttaja_id, 'aanestys_id' => $aanestys_id, 'ehdokas_id' => $ehdokas_id));
        $rivi = $query->fetch();
        
        if ($rivi) {
            return FALSE;
        }
        
        $query = DB::connection()->prepare('SELECT ehdokas_id FROM aanestaneet WHERE kayttaja_id = :kayttaja_id AND aanestys_id = :aanestys_id LIMIT 1');
        $query->execute(array('kayttaja_id' => $kayttaja_id, 'aanestys_id' => $aanestys_id));
        $aiempiehdokas = $query->fetch();
        $aiempiehdokas = $aiempiehdokas['0'];
        
        if ($aiempiehdokas) {
            $query = DB::connection()->prepare('UPDATE ehdokas SET aania = aania-1 WHERE id = :id');
            $query->execute(array('id' => $aiempiehdokas));
            
            $query = DB::connection()->prepare('DELETE FROM aanestaneet WHERE kayttaja_id = :kayttaja_id AND aanestys_id = :aanestys_id AND ehdokas_id = :ehdokas_id');
            $query->execute(array('kayttaja_id' => $kayttaja_id, 'aanestys_id' => $aanestys_id, 'ehdokas_id' => $aiempiehdokas));
        }
        
        $query = DB::connection()->prepare('UPDATE ehdokas SET aania = aania+1 WHERE id = :id');
        $query->execute(array('id' => $ehdokas_id));
        
        $query = DB::connection()->prepare('INSERT INTO aanestaneet (kayttaja_id, aanestys_id, ehdokas_id) VALUES (:kayttaja_id, :aanestys_id, :ehdokas_id)');
        $query->execute(array('kayttaja_id' => $kayttaja_id, 'aanestys_id' => $aanestys_id, 'ehdokas_id' => $ehdokas_id));
        
        return TRUE;
        
    }
    
    //VALIDAATIOT
    
    public function validoiNimi() {
        $nimi = $this->nimi;
        $aanestys_id = $this->aanestys_id;
        $virheet = parent::validoi_string_pituus($nimi, 3, 40, 'Nimen');
        
        $query = DB::connection()->prepare('SELECT * FROM ehdokas WHERE nimi = :nimi AND aanestys_id = :aanestys_id LIMIT 1');
        
        $query->execute(array('nimi' => $nimi, 'aanestys_id'=> $aanestys_id));
        $rivi = $query->fetch();
        
        if ($rivi) {
            $virheet[] = 'Äänestyksessäsi on jo sen niminen ehdokas!';
        }
        
        return $virheet;
    }
    
    
    
}
