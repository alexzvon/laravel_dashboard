<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class UploadCatalogController extends Controller
{
    public function uploadCatalogCreate(Request $request)
    {
//        dd($request->all());

//        return 'swswsededrfrftgtgyhyhyh';

        return response()->json($request->all());

    }
}
