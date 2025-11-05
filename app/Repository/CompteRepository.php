<?php
namespace App\Repository;

use App\Models\Compte;
use Request;
class CompteRepository{
    private Compte $compte;
     public function __construct($compteInjecte){
        $this->compte=$compteInjecte;
    }
    
    public function create($data):Compte{
        return $this->compte->create($data);
    }
    public function all(){
        return $this->compte->all();
    }
  
};