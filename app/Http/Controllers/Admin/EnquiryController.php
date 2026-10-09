<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EnquiryStatus;
use App\Enums\EnquiryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateEnquiryStatusRequest;
use App\Http\Resources\EnquiryResource;
use App\Models\Enquiry;
use App\Services\EnquiryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class EnquiryController extends Controller
{
    public function __construct(private readonly EnquiryService $enquiries) {}

    public function index(Request $request): Response
    {
        $filters = $request->only('status', 'type');

        return Inertia::render('Admin/Enquiries/Index', [
            'enquiries' => EnquiryResource::collection($this->enquiries->paginateFor($request->user(), $filters)),
            'statuses' => EnquiryStatus::options(),
            'types' => EnquiryType::options(),
            'filters' => $filters,
        ]);
    }

    public function update(UpdateEnquiryStatusRequest $request, Enquiry $enquiry): RedirectResponse
    {
        $this->enquiries->updateStatus($enquiry, $request->enum('status', EnquiryStatus::class));

        return back()->with('success', 'Enquiry status updated.');
    }

    public function destroy(Enquiry $enquiry): RedirectResponse
    {
        Gate::authorize('delete', $enquiry);

        $this->enquiries->delete($enquiry);

        return back()->with('success', 'Enquiry deleted.');
    }
}
