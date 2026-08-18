<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileDevice extends Model
{
	protected $fillable = [
		'user_id', 'device_id', 'push_notifications_token', 'logged_out_at'
	];

	protected function casts(): array
	{
		return [
			'logged_out_at' => 'datetime',
		];
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
