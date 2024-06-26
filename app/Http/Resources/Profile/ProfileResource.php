<?php

namespace App\Http\Resources\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array and choosing data to send from response from the API.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'avatar' => $this->avatar,
            ...Auth::guard('sanctum')->check() ? ['status' => $this->status] : [], // If the current user is authenticated, status of profiles are visibles.
            'created_at' => $this->created_at->format('d-m-Y '),
        ];
    }
}
