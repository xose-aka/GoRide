<?php

namespace App\Http\Resources;

use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Driver $this */

        return [
            'id' => $this->id,
            'year' => $this->year,
            'make' => $this->make,
            'color' => $this->color,
            'license_plate' => $this->license_plate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
