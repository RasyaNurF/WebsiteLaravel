<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AdminRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->string('q')->toString();
                $query->where(function ($query) use ($term) {
                    $query->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%");
                });
            })
            ->when($request->filled('role'), fn ($query) => $query->where('role', $request->string('role')->toString()))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Pengguna'],
            ],
            'searchPlaceholder' => 'Cari nama atau email…',
            'searchAction' => route('admin.users.index'),
            'users' => $users,
            'roles' => AdminRole::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Pengguna', 'url' => route('admin.users.index')],
                ['label' => 'Tambah'],
            ],
            'user' => new User,
            'roles' => AdminRole::cases(),
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        User::create([
            ...$request->validated(),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Pengguna', 'url' => route('admin.users.index')],
                ['label' => $user->name],
            ],
            'user' => $user,
            'roles' => AdminRole::cases(),
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if (filled($data['password'] ?? null)) {
            $data['password'] = $request->input('password');
        } else {
            unset($data['password']);
        }

        $user->update([
            ...$data,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->is(auth()->user()), 403, 'Tidak dapat menghapus akun sendiri.');

        if ($user->isSuperAdmin()) {
            abort_if(User::query()->where('role', AdminRole::SuperAdmin->value)->count() <= 1, 403, 'Minimal harus ada satu Super Admin.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
