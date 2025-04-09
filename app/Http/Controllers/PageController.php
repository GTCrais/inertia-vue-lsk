<?php

namespace App\Http\Controllers;

use App\Services\ViewMetadataProviderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
	public function show(Request $request, ViewMetadataProviderService $viewMetadataProviderService, $slug = null)
	{
		if ($request->routeIs('user-account.show')) {
			if ($request->input('verified') == 1) {
				session()->flash('emailVerified');

				return redirect()->route('user-account.show');
			}

			return Inertia::render('UserAccount', [
				'emailVerified' => session('emailVerified')
			]);
		}

		if (!$slug) {
			$viewMetadataProviderService->setTitle('Home');

			return Inertia::render('Home');
		}

		abort(404);
    }
}
