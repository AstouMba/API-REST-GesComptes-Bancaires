<?php
namespace App\Services;
use App\Models\Compte;
use App\Repository\CompteRepository;
use DateTime;
class CompteService{
    private CompteRepository $compteRepository;
    public function __construct($compteRepository){
       $this->compteRepository=$compteRepository;
    }
    public function create($data):Compte{
        $date = new DateTime();
            $data['date_ouverture'] = $date->format('Y-m-d H:i:s');
            $data['numero_compte'] = 'CPT' . rand(100000000, 999999999);
            if (!isset($data['statut'])) {
            $data['statut'] = 'actif';}
            return $this->compteRepository->create($data);
    }

    public function all(){
    return $this->compteRepository->all();
    }
}