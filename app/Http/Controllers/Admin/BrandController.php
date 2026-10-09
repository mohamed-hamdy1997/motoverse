<?php

namespace App\Http\Controllers\Admin;

use App\Enums\BrandSegment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class BrandController extends Controller
{
    public function __construct(private readonly BrandService $brands) {}

    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Brands/Index', [
            'brands' => BrandResource::collection($this->brands->listFor($request->user())),
            'canCreate' => $request->user()->can('create', Brand::class),
        ]);
    }

    public function create(): Response
    {
        Gate::authorize('create', Brand::class);

        return $this->form(null);
    }

    public function store(BrandRequest $request): RedirectResponse
    {
        $this->brands->create($request->safe()->except('cover_image'), $request->file('cover_image'));

        return to_route('admin.brands.index')->with('success', 'Brand created.');
    }

    public function edit(Brand $brand): Response
    {
        Gate::authorize('update', $brand);

        return $this->form($brand);
    }

    public function update(BrandRequest $request, Brand $brand): RedirectResponse
    {
        $this->brands->update($brand, $request->safe()->except('cover_image'), $request->file('cover_image'));

        return to_route('admin.brands.index')->with('success', 'Brand updated.');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        Gate::authorize('delete', $brand);

        $this->brands->delete($brand);

        return to_route('admin.brands.index')->with('success', 'Brand deleted.');
    }

    private function form(?Brand $brand): Response
    {
        return Inertia::render('Admin/Brands/Form', [
            'brand' => $brand ? BrandResource::make($brand) : null,
            'segments' => BrandSegment::options(),
        ]);
    }
}
