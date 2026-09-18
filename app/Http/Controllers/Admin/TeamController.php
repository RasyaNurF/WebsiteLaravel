<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamRequest;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $teams = Team::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.teams.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Tim'],
            ],
            'searchPlaceholder' => 'Cari nama atau posisi…',
            'searchAction' => route('admin.teams.index'),
            'teams' => $teams,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.teams.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Tim', 'url' => route('admin.teams.index')],
                ['label' => 'Tambah'],
            ],
            'team' => new Team,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function store(TeamRequest $request): RedirectResponse
    {
        Team::create($this->applyImageUploads($request, $request->validated(), ['photo_path'], 'teams'));

        return redirect()->route('admin.teams.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(Team $team): View
    {
        return view('admin.teams.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Tim', 'url' => route('admin.teams.index')],
                ['label' => $team->name],
            ],
            'team' => $team,
            'statuses' => PublishStatus::cases(),
        ]);
    }

    public function update(TeamRequest $request, Team $team): RedirectResponse
    {
        $team->update($this->applyImageUploads($request, $request->validated(), ['photo_path'], 'teams', $team));

        return redirect()->route('admin.teams.index')->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(Team $team): RedirectResponse
    {
        $this->deleteImageFiles($team, ['photo_path']);
        $team->delete();

        return redirect()->route('admin.teams.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
