<?php

namespace App\Http\Controllers;

use App\Services\View\ViewFactory;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function view($index, $type, $id, Request $request)
    {
        $options = $request->input('options', []);
//        if (is_numeric($id)) {
//            $id = (float)$id;
//        }
        $viewer = ViewFactory::getViewer($index, $type, $id, $options);
        if (!$viewer) {
            abort(404);
        }
        return view($viewer['view'], $viewer);
    }
}
