<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PublishStatus;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SolutionRequest;
use App\Models\Solution;
use App\Models\SolutionCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SolutionController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $solutions = Solution::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->when($request->filled('category'), fn ($query) => $query->where('solution_category_id', $request->integer('category')))
            ->with('category')
            ->orderBy('sort_order')
            ->paginate(15)
            ->withQueryString();

        return view('admin.solutions.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Solusi'],
            ],
            'searchPlaceholder' => 'Cari nama solusi atau partner…',
            'searchAction' => route('admin.solutions.index'),
            'solutions' => $solutions,
            'statuses' => PublishStatus::cases(),
            'categories' => SolutionCategory::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.solutions.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Solusi', 'url' => route('admin.solutions.index')],
                ['label' => 'Tambah'],
            ],
            'solution' => new Solution,
            'statuses' => PublishStatus::cases(),
            'categories' => SolutionCategory::orderBy('name')->get(),
        ]);
    }

    public function store(SolutionRequest $request): RedirectResponse
    {
        $data = $this->applyImageUploads($request, $request->validated(), ['logo_path', 'cover_image_path'], 'solutions');
        $data = $this->normalizeLists($data);

        Solution::create($data);

        return redirect()->route('admin.solutions.index')->with('success', 'Solusi berhasil ditambahkan.');
    }

    public function edit(Solution $solution): View
    {
        return view('admin.solutions.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Solusi', 'url' => route('admin.solutions.index')],
                ['label' => $solution->title],
            ],
            'solution' => $solution,
            'statuses' => PublishStatus::cases(),
            'categories' => SolutionCategory::orderBy('name')->get(),
        ]);
    }

    public function update(SolutionRequest $request, Solution $solution): RedirectResponse
    {
        $data = $this->applyImageUploads($request, $request->validated(), ['logo_path', 'cover_image_path'], 'solutions', $solution);
        $data = $this->normalizeLists($data);

        $solution->update($data);

        return redirect()->route('admin.solutions.index')->with('success', 'Solusi berhasil diperbarui.');
    }

    public function destroy(Solution $solution): RedirectResponse
    {
        $this->deleteImageFiles($solution, ['logo_path', 'cover_image_path']);
        $solution->delete();

        return redirect()->route('admin.solutions.index')->with('success', 'Solusi berhasil dihapus.');
    }

    /**
     * Ubah textarea fitur/manfaat menjadi array JSON.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function normalizeLists(array $data): array
    {
        foreach (['features', 'benefits'] as $field) {
            $lines = preg_split('/\r\n|\r|\n/', (string) ($data[$field.'_text'] ?? '')) ?: [];
            $data[$field] = collect($lines)
                ->map(fn ($line) => trim($line))
                ->filter()
                ->values()
                ->all();
        }

        unset($data['features_text'], $data['benefits_text']);

        return $data;
    }
}
