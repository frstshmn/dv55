<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
class Material extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function isChecked(){
        $usercomplection = UserComplection::where([
            ['user_id', Auth::user()->id],
            ['material_id', $this->id]
        ])->first();

        if(!empty($usercomplection)){
            return true;
        } else {
            return false;
        }
    }
}
