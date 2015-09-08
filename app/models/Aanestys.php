<?php

class Aanestys extends BaseModel{
    
    public $id, $luonut, $nimi, $kuvaus, $paattyy, $kirjautuminen, $ehdokkaat;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function haeKaikki() {
        $query = DB::connection()->prepare('SELECT * FROM aanestys');
        
        $query->execute();
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
    
    public function haeYksi($id){
        
        $query = DB::connection()->prepare('SELECT * FROM aanestys WHERE id = :id LIMIT 1');
        
        $query->execute(array('id' => $id));
        $rivi = $query->fetch();

        if ($rivi) {
            $aanestys = new Aanestys(array(
               'id' => $rivi['id'],
               'luonut' => $rivi['luonut'],
               'nimi' => $rivi['nimi'],
               'kuvaus' => $rivi['kuvaus'],
               'paattyy' => $rivi['paattyy'],
               'kirjautuminen' => $rivi['kirjautuminen'],
               'ehdokkaat' => Ehdokkaat::haeKaikkiEhdokkaat($id)
            ));
        }
        
        return $aanestys;
    }
    
    public function tallenna() {
        
        $query = DB::connection()->prepare('INSERT INTO aanestys (nimi, luonut, kuvaus, paattyy, kirjautuminen) VALUES (:nimi, :luonut, :kuvaus, :paattyy, :kirjautuminen) RETURNING id');
    
        $query->execute(array('nimi' => $this->nimi, 'luonut' => $this->luonut, 'kuvaus' => $this->kuvaus, 'paattyy' => $this->paattyy, 'kirjautuminen' => $this->kirjautuminen));
        
        $rivi = $query->fetch();
        
        $this->id = $rivi['id'];
    }
    
    public function paivita($id) {
        
        $query = DB::connection()->prepare('UPDATE aanestys SET nimi = :nimi, kuvaus = :kuvaus, paattyy = :paattyy, kirjautuminen = :kirjautuminen WHERE id = :id');
    
        $query->execute(array('id' => $id, 'nimi' => $this->nimi, 'kuvaus' => $this->kuvaus, 'paattyy' => $this->paattyy, 'kirjautuminen' => $this->kirjautuminen));
        
    }
    
    public function poista($id) {
        
        $query = DB::connection()->prepare('DELETE FROM aanestaneet WHERE aanestys_id = :id');
        $query->execute(array('id' => $id));
        
        $query = DB::connection()->prepare('DELETE FROM ehdokas WHERE aanestys_id = :id');
        $query->execute(array('id' => $id));
        
        $query = DB::connection()->prepare('DELETE FROM aanestys WHERE id = :id');
        $query->execute(array('id' => $id));
        
        
    }
    
    
}