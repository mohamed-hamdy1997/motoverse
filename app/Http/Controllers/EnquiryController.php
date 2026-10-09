<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Services\EnquiryService;
use Illuminate\Http\RedirectResponse;

class EnquiryController extends Controller
{
    public function store(StoreEnquiryRequest $request, EnquiryService $enquiries): RedirectResponse
    {
        $enquiries->submit($request->validated());

        return back()->with('success', 'Thank you! Our team will contact you within one working day.');
    }
}
