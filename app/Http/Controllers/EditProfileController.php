<?php

namespace App\Http\Controllers;

use App\Models\User;

class EditProfileController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        if (!$currentUser) {
            return view('login');
        }

        return view('edit-profile', compact( 'currentUser'));

    }
}

?>