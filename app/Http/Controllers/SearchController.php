<?php

namespace App\Http\Controllers;

use App\Services\Elasticsearch\Elasticsearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('term');
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);
        if ($query) {
            $es = new Elasticsearch();
            $res = $es->simpleSearch($query, $page, $pageSize)->toArray();
        } else {
            $res = [];
        }
        return response()->json($res);
    }
}
