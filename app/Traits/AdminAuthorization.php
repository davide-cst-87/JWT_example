<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AdminAuthorization
{
    public function ensureCompanyAdmin()
    {
        $admin = Auth::user();

        if (! $admin || $admin->account_type !== 'company' || ! $admin->hasRole('company-admin')) {
            abort(response()->json([
                'message' => 'You are not authorized to perform this action.',
            ], 403));
        }

        return $admin;
    }
}
