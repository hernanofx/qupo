<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    public function index()
    {
        // public listing (pagination)
        return Merchant::where('active', true)->paginate(10);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'merchant') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $merchant = Merchant::create([
            'owner_id' => $user->id,
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'address' => $data['address'] ?? null,
            'lat' => $data['lat'] ?? null,
            'lng' => $data['lng'] ?? null,
            'active' => false,
        ]);

        return response()->json($merchant, 201);
    }

    public function show(Merchant $merchant)
    {
        return $merchant;
    }

    public function update(Request $request, Merchant $merchant)
    {
        $user = $request->user();
        if ($user->id !== $merchant->owner_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'nullable|string',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'active' => 'nullable|boolean',
        ]);

        $merchant->update($data);
        return $merchant;
    }

    public function destroy(Request $request, Merchant $merchant)
    {
        $user = $request->user();
        if ($user->id !== $merchant->owner_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $merchant->delete();
        return response()->json(null, 204);
    }
}
