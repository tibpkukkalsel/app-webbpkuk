<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    public function view(){
        
        return view('admin.hashtag.view');
    }

    public function search(Request $request)
    {
        $search=$request->q;

        $data=Hashtag::query()
            ->when($search,function($query)use($search){

                $query->where(
                    'hashtag',
                    'like',
                    '%'.$search.'%'
                );

            })
            ->orderBy('hashtag')
            ->limit(20)
            ->get([
                'id_hashtag',
                'hashtag'
            ]);

        return response()->json(
            $data->map(function($item){

                return[
                    'id'=>$item->id_hashtag,
                    'text'=>$item->hashtag
                ];

            })
        );
    }
}
