<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

	protected $fillable = [
		'user_id',
		'sender_id',
		'type',
		'data',
		'title',
		'message',
		'reference_id',
		'is_seen'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'sender_id');
	}

	protected $appends = ['sender_details'];

	public function getSenderDetailsAttribute()
	{
		$sender = User::where('id', $this->sender_id)->first();

		if ($sender) {
			return $sender;
		} else {
			return (object) [
				'user_name' => 'Admin',
				'profile_picture' => 'public/assets/common/images/logo.png'
			];
		}
	}
}
