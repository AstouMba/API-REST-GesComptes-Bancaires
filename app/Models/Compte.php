<?php

namespace App\Models;

use App\Utils\GenererUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Compte extends Model
{
    use HasFactory,GenererUuid;

    protected $keytype = 'string';
    public $incrementing = false;
    protected $table = "comptes";
    protected $casts=[
        'date_ouverture'=>'datetime',
    ];
    protected $fillable= [
        'titulaire',
        'numero_compte',
        'type',
        'devise',
        'date_ouverture',
        'statut',
        'motif_blocage',
        
    ];

public function transactions(){
        return $this->hasMany(Transaction::class, 'compte_id', 'id');
}
 public function solde(){
    $soldeDepot=$this->transactions()->depot()->sum('montant');
    $soldeRetrait=$this->transactions()->retrait()->sum('montant');
    return $soldeDepot-$soldeRetrait;
}

}
