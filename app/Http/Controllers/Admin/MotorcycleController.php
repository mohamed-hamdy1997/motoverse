<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MotorcycleCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MotorcycleRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\MotorcycleResource;
use App\Models\Motorcycle;
use App\Services\BrandService;
use App\Services\MotorcycleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class MotorcycleController extends Controller
{
    public function __construct(
        private readonly MotorcycleService $motorcycles,
        private readonly BrandService $brands,
    ) {}

    public function index(Request $request): Response
    {
        $filters = $request->only('search', 'brand_id');

        return Inertia::render('Admin/Motorcycles/Index', [
            'motorcycles' => MotorcycleResource::collection($this->motorcycles->paginateFor($request->user(), $filters)),
            'brands' => BrandResource::collection($this->brands->optionsFor($request->user())),
            'filters' => $filters,
        ]);
    }

    public function create(Request $request): Response
    {
        Gate::authorize('create', Motorcycle::class);

        return $this->form($request, null);
    }

    public function store(MotorcycleRequest $request): RedirectResponse
    {
        $this->motorcycles->create($request->safe()->except('image'), $request->file('image'));

        return to_route('admin.motorcycles.index')->with('success', 'Motorcycle created.');
    }

    public function edit(Request $request, Motorcycle $motorcycle): Response
    {
        Gate::authorize('update', $motorcycle);

        return $this->form($request, $motorcycle);
    }

    public function update(MotorcycleRequest $request, Motorcycle $motorcycle): RedirectResponse
    {
        $this->motorcycles->update($motorcycle, $request->safe()->except('image'), $request->file('image'));

        return to_route('admin.motorcycles.index')->with('success', 'Motorcycle updated.');
    }

    public function destroy(Motorcycle $motorcycle): RedirectResponse
    {
        Gate::authorize('delete', $motorcycle);

        $this->motorcycles->delete($motorcycle);

        return back()->with('success', 'Motorcycle deleted.');
    }

    private function form(Request $request, ?Motorcycle $motorcycle): Response
    {
        return Inertia::render('Admin/Motorcycles/Form', [
            'motorcycle' => $motorcycle ? MotorcycleResource::make($motorcycle) : null,
            'brands' => BrandResource::collection($this->brands->optionsFor($request->user())),
            'categories' => MotorcycleCategory::options(),
        ]);
    }
}
