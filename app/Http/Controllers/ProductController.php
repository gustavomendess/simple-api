<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            ['id' => 1, 'nome' => 'produto 1'],
            ['id' => 2, 'nome' => 'produto 2'],
            ['id' => 3, 'nome' => 'produto 3'],
            ['id' => 4, 'nome' => 'produto 4'],
            ['id' => 5, 'nome' => 'produto 5'],
        ]);
    }
}
