<?php

namespace App\Services;

class ViewMetadataProviderService
{
	protected $title;
	protected $description;
	protected $keywords;
	protected $ogType = 'website';
	protected $ogImage;
	protected $twitterImage;

	public function __construct()
	{
		$this->title = config('app.name');
		$this->description = config('app.name') . ' - slogan!';
		$this->keywords = config('app.name');
		$this->ogImage = url('storage/assets/misc/default_share_img.png');
		$this->twitterImage = url('storage/assets/misc/twitter_share_img.png');
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getTitle()
	{
		return ($this->title && ($this->title != config('app.name'))) ? $this->title . ' :: ' . config('app.name') : $this->title;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function setKeywords($keywords)
	{
		$this->keywords = $keywords;
	}

	public function getKeywords() {
		return $this->keywords;
	}

	public function setOgType($ogType)
	{
		$this->ogType = $ogType;
	}

	public function getOgType() {
		return $this->ogType;
	}

	public function setOgImage($ogImage) {
		$this->ogImage = $ogImage;
	}

	public function getOgImage() {
		return $this->ogImage;
	}

	public function setTwitterImage($twitterImage) {
		$this->twitterImage = $twitterImage;
	}

	public function getTwitterImage() {
		return $this->twitterImage;
	}

	public function toArray()
	{
		return [
			'title' => $this->getTitle(),
			'description' => $this->getDescription(),
			'keywords' => $this->getKeywords(),
			'ogType' => $this->getOgType(),
			'ogImage' => $this->getOgImage(),
			'twitterImage' => $this->getTwitterImage()
		];
	}
}