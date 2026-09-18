<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PasswordRequest;
use App\Http\Requests\Admin\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use HandlesImageUploads;

    public function edit(): View
    {
        return view('admin.profile.edit', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Profil'],
            ],
            'user' => auth()->user(),
        ]);
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $user->update($this->applyImageUploads($request, $request->validated(), ['avatar_path'], 'profiles', $user));

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(PasswordRequest $request): RedirectResponse
    {
        auth()->user()->update(['password' => $request->validated('password')]);

        return redirect()->route('admin.profile.edit')->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
