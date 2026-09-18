<?php

namespace App\Http\Controllers\Public;

use App\Enums\PublishStatus;
use App\Enums\ResourceType;
use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(): View
    {
        $resources = Resource::query()
            ->where('status', PublishStatus::Published->value)
            ->orderByDesc('published_at')
            ->latest('id')
            ->paginate(9);

        return view('resources.index', [
            'resources' => $resources,
            'types' => ResourceType::cases(),
        ]);
    }

    public function type(string $type): View
    {
        $resourceType = ResourceType::tryFrom($type);
        abort_if($resourceType === null, 404);

        $resources = Resource::query()
            ->where('status', PublishStatus::Published->value)
            ->where('type', $resourceType->value)
            ->orderByDesc('published_at')
            ->latest('id')
            ->paginate(9);

        return view('resources.type', [
            'resourceType' => $resourceType,
            'resources' => $resources,
            'types' => ResourceType::cases(),
        ]);
    }

    public function show(string $type, Resource $resource): View
    {
        $resourceType = ResourceType::tryFrom($type);
        abort_if($resourceType === null || $resource->type !== $resourceType, 404);
        abort_unless($resource->status === PublishStatus::Published, 404);

        $related = Resource::query()
            ->where('status', PublishStatus::Published->value)
            ->where('type', $resourceType->value)
            ->whereKeyNot($resource->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('resources.show', [
            'resource' => $resource,
            'resourceType' => $resourceType,
            'related' => $related,
        ]);
    }
}
