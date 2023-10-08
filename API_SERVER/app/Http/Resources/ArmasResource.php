<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArmasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Index' => $this->index,
            'Nome' => $this->nome,
            'Alcance' => $this->alcance,
            'Dano' => $this->dano,
            'Tipo de Dano' => $this->tipo_de_dano,
            'Propriedades' => $this->propriedades,
        ];
    }
}
