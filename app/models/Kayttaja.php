<?php

class Kayttaja extends BaseModel{
    
    public $id, $nimi, $salasana;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validointi = array('validoiSalasana', 'validoiNimi');
    }
    
    public static function haeKaikki() {
        $query = DB::connection()->prepare('SELECT nimi FROM kayttaja');
        
        $query->execute();
        $rivit = $query->fetchAll();
        $kayttajat = array();
        
        foreach ($rivit as $rivi) {
            $kayttajat[] = new Kayttaja(array(
               'nimi' => $rivi['nimi']
            ));
            
        }
        
        return $kayttajat;
    }
    
    public static function haeYksi($id){
        
        $query = DB::connection()->prepare('SELECT * FROM kayttaja WHERE id = :id LIMIT 1');
        
        $query->execute(array('id' => $id));
        $rivi = $query->fetch();

        if ($rivi) {
            $kayttaja = new Kayttaja(array(
               'id' => $rivi['id'],
               'nimi' => $rivi['nimi'],
               'salasana' => $rivi['salasana']
            ));
        }
        
        return $kayttaja;
    }
    
    public static function validoi($nimi, $salasana){
        
        $query = DB::connection()->prepare('SELECT * FROM kayttaja WHERE nimi = :nimi AND salasana = :salasana LIMIT 1');
        $query->execute(array('nimi' => $nimi, 'salasana' => $salasana));
        $rivi = $query->fetch();
        
        if ($rivi) {
            $kayttaja = new Kayttaja(array(
               'id' => $rivi['id'],
               'nimi' => $rivi['nimi']
            ));
            
            return $kayttaja;
        } else {
            return null;
        }
    }
    
    public function tallenna() {
        
        $query = DB::connection()->prepare('INSERT INTO kayttaja (nimi, salasana) VALUES (:nimi, :salasana)');
    
        $query->execute(array('nimi' => $this->nimi, 'salasana' => $this->salasana));
    }
    
    public function muokkaa($id) {
        
        $query = DB::connection()->prepare('UPDATE kayttaja SET nimi = :nimi, salasana = :salasana WHERE id = :id');
    
        $query->execute(array('id' => $id, 'nimi' => $this->nimi, 'salasana' => $this->salasana));
        
    }
    
    public function poista($id) {
        
        $query = DB::connection()->prepare('DELETE FROM aanestaneet WHERE kayttaja_id = :id');
        $query->execute(array('id' => $id));
        
        $query = DB::connection()->prepare('DELETE FROM aanestys WHERE luonut = :id');
        $query->execute(array('id' => $id));
        
        $query = DB::connection()->prepare('DELETE FROM kayttaja WHERE id = :id');
        $query->execute(array('id' => $id));
        
        
    }
    
    public static function omatAanestykset($id) {
        
        $query = DB::connection()->prepare('SELECT * FROM aanestys WHERE luonut = :id');
    
        $query->execute(array('id' => $id));
        
        $rivit = $query->fetchAll();
        $aanestykset = array();
        
        foreach ($rivit as $rivi) {
            $aanestykset[] = new Aanestys(array(
               'id' => $rivi['id'],
               'luonut' => $rivi['luonut'],
               'nimi' => $rivi['nimi'],
               'kuvaus' => $rivi['kuvaus'],
               'paattyy' => $rivi['paattyy'],
               'kirjautuminen' => $rivi['kirjautuminen']
            ));
            
        }
        
        return $aanestykset;
        
    }
    
    
    //VALIDAATIOT
    
    public function validoiNimi() {
        $nimi = $this->nimi;
        $virheet = parent::validoi_string_pituus($nimi, 3, 'Nimen');
        
        $query = DB::connection()->prepare('SELECT * FROM kayttaja WHERE nimi = :nimi LIMIT 1');
        
        $query->execute(array('nimi' => $nimi));
        $rivi = $query->fetch();
        
        if ($rivi) {
            $virheet[] = 'Nimi on jo käytössä!';
        }
        
        return $virheet;
    }
    
    public function validoiSalasana() {
        $salasana = $this->salasana;
        $virheet = parent::validoi_string_pituus($salasana, 3, 'Salasanan');
        return $virheet;
    }
    
    
    
    
    
}