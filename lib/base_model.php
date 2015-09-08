<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validointi;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }
    
    public function validoi_string_pituus($string, $min, $minka) {
        $virheet = array();
        $pituus = strlen($string);
        if ($pituus < $min) {
            $virheet[] = $minka . ' pitää olla vähintään ' . $min . ' merkkiä pitkä';
        } 
        
        return $virheet;
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validointi as $validoija){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
          $metodi = $validoija;
          $virhe = $this->{$metodi}();
          $errors = array_merge($errors, $virhe);
          
      }

      return $errors;
    }

  }
