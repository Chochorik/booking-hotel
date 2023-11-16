<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\JsonResponse;

class FacilityController extends Controller
{
    public function index(): JsonResponse
    {
        $facilities = Facility::all(['id', 'title']);

        return response()->json($facilities);
    }
}
