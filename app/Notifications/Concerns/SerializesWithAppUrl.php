<?php

namespace App\Notifications\Concerns;

use Illuminate\Support\Facades\URL;

trait SerializesWithAppUrl
{
	public string $appUrl;

	public function __serialize()
	{
		$this->appUrl = rtrim(url('/'), '/');

		return parent::__serialize();
	}

	public function __unserialize(array $values)
	{
		parent::__unserialize($values);

		URL::useOrigin($this->appUrl);
	}
}
