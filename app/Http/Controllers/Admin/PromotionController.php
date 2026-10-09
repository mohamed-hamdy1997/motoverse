<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PromotionRequest;
use App\Http\Resources\BrandResource;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use App\Services\BrandService;
use App\Services\PromotionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PromotionController extends Controller
{
    public function __construct(
        private readonly PromotionService $promotions,
        private readonly BrandService $brands,
    ) {}

    public function index(Request $request): Response
    {
        $filters = $request->only('search', 'brand_id');

        return Inertia::render('Admin/Promotions/Index', [
            'promotions' => PromotionResource::collection($this->promotions->paginateFor($request->user(), $filters)),
            'brands' => BrandResource::collection($this->brands->optionsFor($request->user())),
            'filters' => $filters,
        ]);
    }

    public function create(Request $request): Response
    {
        Gate::authorize('create', Promotion::class);

        return $this->form($request, null);
    }

    public function store(PromotionRequest $request): RedirectResponse
    {
        $this->promotions->create($request->validated());

        return to_route('admin.promotions.index')->with('success', 'Promotion created.');
    }

    public function edit(Request $request, Promotion $promotion): Response
    {
        Gate::authorize('update', $promotion);

        return $this->form($request, $promotion);
    }

    public function update(PromotionRequest $request, Promotion $promotion): RedirectResponse
    {
        $this->promotions->update($promotion, $request->validated());

        return to_route('admin.promotions.index')->with('success', 'Promotion updated.');
    }

    public function destroy(Promotion $promotion): RedirectResponse
    {
        Gate::authorize('delete', $promotion);

        $this->promotions->delete($promotion);

        return back()->with('success', 'Promotion deleted.');
    }

    private function form(Request $request, ?Promotion $promotion): Response
    {
        return Inertia::render('Admin/Promotions/Form', [
            'promotion' => $promotion ? PromotionResource::make($promotion) : null,
            'brands' => BrandResource::collection($this->brands->optionsFor($request->user())),
        ]);
    }
}
