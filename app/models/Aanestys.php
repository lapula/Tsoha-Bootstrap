<?php

class Aanestys extends BaseModel{
    
    public $id, $luonut, $nimi, $kuvaus, $paattyy, $kirjautuminen, $ehdokkaat;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validointi = array('validoiKuvaus', 'validoiPaattyy', 'validoiNimi');
    }
    
    public static function haeKaikki() {
        $query = DB::connection()->prepare('SELECT * FROM aanestys ORDER BY aanestys.paattyy ASC');
        
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
               'paattyy' => date('d.m.Y', strtotime($rivi['paattyy'])),
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
    
    public static function tarkistaOikeudet($id, $kayttaja){
      
        $query = DB::connection()->prepare('SELECT luonut FROM aanestys WHERE aanestys.id = :id LIMIT 1');
        
        $query->execute(array('id' => $id));
        $rivi = $query->fetch();
        
        if ($rivi[0] == $kayttaja) {
            return true;
        }
        
        return false;
        
    }
    
    //VALIDOINTI
    
    public function validoiNimi() {
        $nimi = $this->nimi;
        $virheet = parent::validoi_string_pituus($nimi, 3, 40, 'Nimen');
        
        $query = DB::connection()->prepare('SELECT id, nimi FROM aanestys WHERE nimi = :nimi LIMIT 1');
        
        $query->execute(array('nimi' => $nimi));
        $rivi = $query->fetch();
        
        if ($rivi['nimi'] == $nimi && $rivi['id'] != $this->id) {
            $virheet[] = 'Sen niminen äänestys on jo olemassa!';
        }
        
        return $virheet;
    }
    
    public function validoiKuvaus() {
        $kuvaus = $this->kuvaus;
        $virheet = parent::validoi_string_pituus($kuvaus, 5, 400, 'Kuvauksen');
        return $virheet;
    }
    
    public function validoiPaattyy() {
        $paattyy = $this->paattyy;
        $virheet = array();
        
        $osat = explode(".", $paattyy);
        
        if ((count($osat) == 3)) {
            if (!checkdate($osat[1], $osat[0], $osat[2])) {
                $virheet[] = 'Syötä oikeanmuotoinen päivämäärä! (pp.kk.vvvv)';
                return $virheet;
            }
        } else {
            $virheet[] = 'Syötä oikeanmuotoinen päivämäärä! (pp.kk.vvvv)';
            return $virheet;
        }
        
        if (strtotime(date('d.m.y')) > strtotime($paattyy)) {
            $virheet[] = 'Päättymispäivä ei saa olla menneisyydessä (eikä nykyinen päivä)!';
        }
        return $virheet;
    }
    
    
}