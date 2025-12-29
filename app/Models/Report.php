<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

  public $table = "reports";
  protected $fillable = ['user_id', 'other_user_id', 'group_id', 'post_id', 'reason'];

  public function reportUser()
  {
    return $this->hasOne('App\Models\User', 'id', 'user_id');
  }
  public function user_details()
  {
    return $this->hasOne('App\Models\User', 'id', 'other_user_id');
  }
  public function post_details()
  {
    return $this->hasOne('App\Models\Post', 'id', 'post_id');
  }
  public function group_details()
  {
    return $this->hasOne('App\Models\Group', 'id', 'group_id');
  }
}
