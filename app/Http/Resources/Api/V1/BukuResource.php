<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class BukuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'pengarang' => $this->pengarang,
            'penerbit' => $this->penerbit,
            'tahun_terbit' => $this->tahun_terbit,
            'isbn' => $this->isbn,
            'stok' => $this->stok,
            'kategori_id' => $this->kategori_id,

            // HATEOAS Links
            'links' => [
                'self' => url('/api/v1/bukus/' . $this->id),
                'collection' => url('/api/v1/bukus'),
            ],
        ];
    }
}
