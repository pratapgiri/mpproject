<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserDevice extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','device_token', 'device_type','device_unique_id', 'created_at', 'updated_at'
    ];
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public static function deviceHandle($data){

        $userDevice = UserDevice::where(['user_id'=> $data['id'],'device_unique_id'=>$data['device_unique_id']])->first();
        if($userDevice){
			    $userDevice->device_type = $data['device_type'];
                $userDevice->device_token = $data['device_token'];
                $userDevice->save();
        }else{
            self::createDevice($data);
        }
        return true;
    }

    public static function createDevice($data){

        $device = UserDevice::create([
            "user_id"       =>  $data['id'],
            "device_type"   =>  $data['device_type'],
            "device_token"  =>  $data['device_token'],
            "device_unique_id"  =>  $data['device_unique_id'],
        ]);
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
