<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $keytype = 'string';
    public $incrementing = false;  
    protected $table = "transactions";

      protected $casts = [
        'montant' => 'decimal:2',
    ];
        public function compte()
    {
        return $this->belongsTo(Compte::class);
    }
      public function scopeDepot($query)
    {
        return $query->where('type', 'depot');
    }

    public function scopeRetrait($query)
    {
        return $query->where('type', 'retrait');
    }
}

