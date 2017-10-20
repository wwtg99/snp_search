<?php

namespace App\Http\Controllers;

use App\Services\WebService\EnsembleAPI;
use Illuminate\Http\Request;

class VariantController extends Controller
{

    public function kgFreq(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return ['error'=>'No ids provided'];
        }
        $ids = array_map('trim', preg_split('/[\s,]+/', $ids));
        $ensemble = new EnsembleAPI(['pops'=>1]);
        $res = $ensemble->request($ids);
        return response()->json($res);
    }
}
