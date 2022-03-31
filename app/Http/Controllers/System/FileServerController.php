<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class FileServerController extends Controller
{
    public function product($path)
    {
        $this->authorize('view-any products', Product::class);

        if (!Storage::disk('products')->exists($path)) {
            abort('404');
        }

        return Storage::disk('products')->get($path);
    }
}
