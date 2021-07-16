<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserComplection;

class UserComplectionController extends Controller
{
    public function create(Request $request){

        $usercomplection = UserComplection::where([
            ['user_id', '=', $request->user_id],
            ['material_id', '=', $request->material_id],
        ])->first();

        if(empty($usercomplection)){
            $usercomplection = new UserComplection();
            $usercomplection->user_id = $request->user_id;
            $usercomplection->material_id = $request->material_id;
            $usercomplection->completed = 1;
            $usercomplection->save();
        }


    }
}
