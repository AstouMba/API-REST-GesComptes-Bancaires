<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Compte extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titulaire' => $this->titulaire,
            'numero_compte' => $this->numero_compte,
            'type' => $this->type,
            'devise' => $this->devise,
            'date_ouverture' => $this->date_ouverture,
            'statut' => $this->statut,
            'motif_blocage' => $this->motif_blocage,
            'solde' => $this->solde(),
            'created_at' => $this->created_at->toDateTimeString(),
            'links' => [
                'self' => route('comptes.show', $this->id),
                'update' => route('comptes.update', $this->id),
                'delete' => route('comptes.destroy', $this->id),
            ],

        ];
    }
}
