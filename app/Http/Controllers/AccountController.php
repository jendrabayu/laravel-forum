<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function account()
    {
        return view('account.index', ['user' => auth()->user()]);
    }

    public function updateAccount(Request $request)
    {
        $user = auth()->user();

        $validated = $this->validate($request, [
            'avatar' => ['nullable', 'mimes:jpeg,jpg,png,svg', 'max:1000'],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'unique:users,email,' . $user->id, 'email'],
            'username' => ['required', 'unique:users,username,' . $user->id, 'max:50']

        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('images/avatar', 'public');
            Storage::delete($user->avatar);
        } else {
            $validated['avatar'] = $user->avatar;
        }

        $user->update($validated);
        return back()->with('status', 'Akun Anda berhasil diupdate');
    }

    public function password()
    {
        return view('account.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'max:255', 'string', 'confirmed']
        ]);

        $user = auth()->user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update(['password' => Hash::make($request->password)]);
            return back()->with('status', 'Password Anda berhasil diganti');
        }

        return back()->with('status_warning', 'Password lama anda tidak valid');
    }
}
