<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function open() 
    {
        $generator = ([
            'author     :'=>'R-nensia',
            'token type :'=>'bearer',
        ]);
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('generator','data'),200);
    }

    public function closed() 
    {
        $generator = ([
            'author     :'=>'R-nensia',
            'token type :'=>'bearer',
        ]);
        $data = "Only authorized users can see this closed data";
        return response()->json(compact('generator','data'),200);
    }
}
