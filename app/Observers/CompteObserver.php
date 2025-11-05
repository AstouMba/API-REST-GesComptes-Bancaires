<?php

namespace App\Observers;

use App\Models\Compte;

class CompteObserver
{
    /**
     * Handle the Compte "creating" event.
     */
    public function creating(Compte $compte): void
    {
        if (empty($compte->numero_compte)) {
            $lastCompte = Compte::orderBy('created_at', 'desc')->first();
            $lastNumber = $lastCompte ? (int) substr($lastCompte->numero_compte, 3) : 0;
            $nextNumber = $lastNumber + 1;
            $compte->numero_compte = 'CPT' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        }

        if (empty($compte->statut)) {
            $compte->statut = 'actif';
        }

        if (empty($compte->date_ouverture)) {
            $compte->date_ouverture = now();
        }
    }
}
