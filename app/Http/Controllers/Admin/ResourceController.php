<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Enums\ResourceType;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResourceRequest;
use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResourceController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $resources = Resource::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')->toString()))
            ->orderByDesc('published_at')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.resources.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Resources'],
            ],
            'searchPlaceholder' => 'Cari judul resources…',
            'searchAction' => route('admin.resources.index'),
            'resources' => $resources,
            'statuses' => PublishStatus::cases(),
            'types' => ResourceType::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.resources.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Resources', 'url' => route('admin.resources.index')],
                ['label' => 'Tambah'],
            ],
            'resource' => new Resource,
            'statuses' => PublishStatus::cases(),
            'types' => ResourceType::cases(),
        ]);
    }

    public function store(ResourceRequest $request): RedirectResponse
    {
        $data = $this->applyImageUploads($request, $request->validated(), ['cover_image_path', 'file_path'], 'resources');
        $data = $this->normalizeLists($data);

        if ($data['status'] === PublishStatus::Published->value && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Resource::create($data);

        return redirect()->route('admin.resources.index')->with('success', 'Resource berhasil ditambahkan.');
    }

    public function edit(Resource $resource): View
    {
        return view('admin.resources.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Resources', 'url' => route('admin.resources.index')],
                ['label' => $resource->title],
            ],
            'resource' => $resource,
            'statuses' => PublishStatus::cases(),
            'types' => ResourceType::cases(),
        ]);
    }

    public function update(ResourceRequest $request, Resource $resource): RedirectResponse
    {
        $data = $this->applyImageUploads($request, $request->validated(), ['cover_image_path', 'file_path'], 'resources', $resource);
        $data = $this->normalizeLists($data);

        if ($data['status'] === PublishStatus::Published->value && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $resource->update($data);

        return redirect()->route('admin.resources.index')->with('success', 'Resource berhasil diperbarui.');
    }

    public function destroy(Resource $resource): RedirectResponse
    {
        $this->deleteImageFiles($resource, ['cover_image_path', 'file_path']);
        $resource->delete();

        return redirect()->route('admin.resources.index')->with('success', 'Resource berhasil dihapus.');
    }

    /**
     * Ubah textarea multi-baris menjadi array JSON.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizeLists(array $data): array
    {
        $data['agenda'] = $this->mapPiped($data['agenda_text'] ?? '', ['time', 'title', 'description']);
        $data['speakers'] = $this->mapPiped($data['speakers_text'] ?? '', ['name', 'position', 'photo']);
        $data['metrics'] = $this->mapPiped($data['metrics_text'] ?? '', ['label', 'value']);
        $data['chapters'] = $this->mapPiped($data['chapters_text'] ?? '', ['title', 'description']);
        $data['gallery'] = $this->mapLines($data['gallery_text'] ?? '');
        $data['toc'] = $this->mapLines($data['toc_text'] ?? '');

        unset($data['agenda_text'], $data['speakers_text'], $data['gallery_text'], $data['metrics_text'], $data['toc_text'], $data['chapters_text']);

        return $data;
    }

    /**
     * @param  list<string>  $keys
     * @return list<array<string, string>>
     */
    private function mapPiped(string $text, array $keys): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $text) ?: [])
            ->map(fn (string $line) => array_map('trim', explode('|', $line)))
            ->filter(fn (array $parts) => filled($parts[0] ?? null))
            ->map(function (array $parts) use ($keys) {
                $row = [];
                foreach ($keys as $i => $key) {
                    $row[$key] = $parts[$i] ?? '';
                }

                return $row;
            })
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    private function mapLines(string $text): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $text) ?: [])
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }
}
