<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $res = [['type'=>'dbSNP', 'id'=>'ggg', 'title'=>'adfasfg', 'abstract'=>'gasdfasg', 'link'=>'/aaa', 'visibility'=>true], ['type'=>'bbb', 'id'=>'gge', 'title'=>'asfdas', 'abstract'=>'ggee', 'visibility'=>true]];
//        $res = [];
        return response()->json($res);
    }
}
