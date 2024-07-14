<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ApiKey;

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ApiKey::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string',
            'expires_at' => 'nullable|date',
        ]);

        $apiKey = ApiKey::create([
            'key' => Str::random(32),
            'name' => $request->name,
            'expires_at' => $request->expires_at,
        ]);

        return response()->json($apiKey, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $apiKey = ApiKey::find($id);
        if (!$apiKey) {
            return response()->json(['message' => 'API Key not found'], 404);
        }

        // Deactivate the API key if it's active
        if ($apiKey->is_active) {
            $apiKey->is_active = false;
            $apiKey->save();
        }

        $apiKey->delete();
        return response()->json(['message' => 'API Key deleted successfully']);
    }

    /**
     * Activate API key.
     */
    public function activate($id)
    {
        $apiKey = ApiKey::find($id);
        if (!$apiKey) {
            return response()->json(['message' => 'API Key not found'], 404);
        }

        $apiKey->is_active = true;
        $apiKey->save();

        return response()->json(['message' => 'API Key activated successfully']);
    }

    /**
     * Deactivate API key.
     */
    public function deactivate($id)
    {
        $apiKey = ApiKey::find($id);
        if (!$apiKey) {
            return response()->json(['message' => 'API Key not found'], 404);
        }

        $apiKey->is_active = false;
        $apiKey->save();

        return response()->json(['message' => 'API Key deactivated successfully']);
    }
}
