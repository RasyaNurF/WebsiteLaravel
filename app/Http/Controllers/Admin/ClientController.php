<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ClientStatus;
use App\Http\Controllers\Admin\Concerns\HandlesImageUploads;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    use HandlesImageUploads;

    public function index(Request $request): View
    {
        $clients = Client::query()
            ->search($request->string('q')->toString())
            ->withStatus($request->string('status')->toString())
            ->withCount('projects')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.clients.index', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Klien'],
            ],
            'searchPlaceholder' => 'Cari nama, industri, atau email…',
            'searchAction' => route('admin.clients.index'),
            'clients' => $clients,
            'statuses' => ClientStatus::cases(),
        ]);
    }

    public function create(): View
    {
        return view('admin.clients.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Klien', 'url' => route('admin.clients.index')],
                ['label' => 'Tambah'],
            ],
            'client' => new Client,
            'statuses' => ClientStatus::cases(),
        ]);
    }

    public function store(ClientRequest $request): RedirectResponse
    {
        Client::create($this->applyImageUploads($request, $request->validated(), ['logo_path'], 'clients'));

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit(Client $client): View
    {
        return view('admin.clients.form', [
            'breadcrumbs' => [
                ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
                ['label' => 'Klien', 'url' => route('admin.clients.index')],
                ['label' => $client->name],
            ],
            'client' => $client,
            'statuses' => ClientStatus::cases(),
        ]);
    }

    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($this->applyImageUploads($request, $request->validated(), ['logo_path'], 'clients', $client));

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil diperbarui.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $this->deleteImageFiles($client, ['logo_path']);
        $client->projects()->update(['client_id' => null]);
        $client->portfolios()->update(['client_id' => null]);
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Klien berhasil dihapus.');
    }
}
