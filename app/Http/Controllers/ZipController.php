<?php

namespace App\Http\Controllers;

use App\Http\Resources\ZipCode as ZipCodeResource;
use App\Models\ZipCode;

class ZipController extends Controller
{
    public function show(ZipCode $zipcode)
    {
        return response()->json(new ZipCodeResource($zipcode));
    }
}
