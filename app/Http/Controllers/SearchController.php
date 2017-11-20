<?php

namespace App\Http\Controllers;

use App\Services\Elasticsearch\Elasticsearch;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('term');
        $type = $request->input('database');
        $page = $request->input('page', 1);
        $pageSize = $request->input('page_size', 10);
        if ($query) {
            $index = config("search.types.$type.index", $type);
            $es = new Elasticsearch($type, $index);
            $res = $es->simpleSearch($query, $page, $pageSize)->toArray();
        } else {
            $res = ['error'=>'No search term'];
        }
        return response()->json($res);
    }

    public function databases()
    {
        $types = config('search.types');
        $select = [];
        foreach ($types as $type => $conf) {
            if (isset($conf['selectable']) && $conf['selectable']) {
                $select[] = ['key'=>$type, 'label'=>$conf['label']];
            }
        }
        return response()->json($select, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
