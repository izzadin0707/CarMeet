<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($id, $hash)
    {
        $user = Users::find($id);

        if (!$user || sha1($user->getEmailForVerification()) !== $hash) {
            return redirect('/')->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/')->with('error', 'Email already verified.');
        }

        $user->markEmailAsVerified();

        return redirect('/')->with('success', 'Email verified successfully!');
    }
}
