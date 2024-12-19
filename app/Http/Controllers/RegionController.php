<?php

namespace App\Http\Controllers;

use App\Models\Region;

class RegionController extends Controller
{
    public function index()
    {
        // Ambil semua wilayah hierarki mulai dari parent_id null (provinsi)
        $regions = Region::with('children')->whereNull('parent_id')->get();

        return response()->json($regions, 200);
    }
}