<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Transportation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $cities = City::get();
        return view('index', compact('cities'));
    }

    public function list(Request $request)
    {
        $request->validate([
            'sourceKladr' => 'required|string',
            'targetKladr' => 'required|string',
        ]);

        $source_city = City::where('kladr_code', $request->sourceKladr)->first();
        if (!$source_city)
            abort(404);
        $target_city = City::where('kladr_code', $request->targetKladr)->first();
        if (!$target_city)
            abort(404);

        $transportations = Transportation::with(['company', 'source', 'target'])
            ->where('source_city', $source_city->id)
            ->where('target_city', $target_city->id)
            ->get();

        return view('results', compact('transportations'));
    }
}
