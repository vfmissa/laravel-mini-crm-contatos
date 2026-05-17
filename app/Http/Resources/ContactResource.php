<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getDatabaseId() ?? $this->getId(),
            'name'         => $this->getName()->getValue(),
            'email'        => $this->getEmail()->getValue(),
            'phone'        => $this->getPhone()->getValue(),
            'status'       => $this->getStatus()->value,
            'score'        => $this->getScore(),
        ];
    }
}