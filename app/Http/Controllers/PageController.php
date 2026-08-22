<?php

namespace App\Http\Controllers;

use App\Services\ViewMetadataProviderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
	public function show(Request $request, ViewMetadataProviderService $viewMetadataProviderService, $slug = null)
	{
		if (!$slug) {
			$viewMetadataProviderService->setTitle('Home');

			return Inertia::render('Home');
		}

		abort(404);
    }
}
