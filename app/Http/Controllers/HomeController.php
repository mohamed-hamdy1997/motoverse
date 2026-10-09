<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Http\Resources\PromotionResource;
use App\Http\Resources\ShowroomResource;
use App\Services\HomePageService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(HomePageService $homePage): Response
    {
        return Inertia::render('Home', [
            'brands' => BrandResource::collection($homePage->brands()),
            'promotions' => PromotionResource::collection($homePage->runningPromotions()),
            'showrooms' => ShowroomResource::collection($homePage->showrooms()),
            'enquiryTypes' => $homePage->enquiryTypes(),
        ]);
    }
}
