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
        'client_id',
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

public function client(){
    return $this->belongsTo(Client::class, 'client_id', 'id');
}
 public function solde(){
    $soldeDepot=$this->transactions()->depot()->sum('montant');
    $soldeRetrait=$this->transactions()->retrait()->sum('montant');
    return $soldeDepot-$soldeRetrait;
}
   public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
    
    public function scopeStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }

    public function scopeSearch($query, $search)
    {
          return $query->where(function ($q) use ($search) {
              $q->where('numero_compte', 'like', '%' . $search . '%')
                ->orWhereHas('client', function ($clientQuery) use ($search) {
                    $clientQuery->where('titulaire', 'like', '%' . $search . '%');
                });
          });
      }

}
