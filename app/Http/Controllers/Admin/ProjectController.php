<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProjectStatus;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectRequest;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $projects = Project::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->with('client')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = Project::query()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin.projects.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Proyek'],
            ],
            'searchPlaceholder' => 'Cari nama, kategori, atau klien…',
            'searchAction' => route('admin.projects.index'),
            'projects' => $projects,
            'statuses' => ProjectStatus::cases(),
            'categories' => $categories,
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Proyek', 'url' => route('admin.projects.index')],
                ['label' => 'Tambah'],
            ],
            'project' => new Project,
            'clients' => Client::orderBy('name')->get(),
            'statuses' => ProjectStatus::cases(),
        ]);
    }

    public function store(ProjectRequest $request): RedirectResponse
    {
        $project = new Project($this->applyImageUploads($request, $request->validated(), ['image_path'], 'projects'));
        $project->save();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Proyek', 'url' => route('admin.projects.index')],
                ['label' => $project->name],
            ],
            'project' => $project,
            'clients' => Client::orderBy('name')->get(),
            'statuses' => ProjectStatus::cases(),
        ]);
    }

    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($this->applyImageUploads($request, $request->validated(), ['image_path'], 'projects', $project));

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->deleteImageFiles($project, ['image_path']);
        $project->portfolios()->update(['project_id' => null]);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus.');
    }
}
