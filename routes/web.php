<?php

use Illuminate\Support\Facades\Route;
use App\Models\Hero;
use App\Models\Service;
use App\Models\Portfolio;
use App\Models\Testimonial;
use App\Models\Footer;
use App\Models\SectionSetting;

Route::get('/', function () {
    $hero = Hero::first();
    
    $services = Service::all(); 
    
    $portfolios = Portfolio::with('service')->latest()->get(); 

    $testimonials = Testimonial::latest()->get();

    $footer = Footer::first();

    $sectionSetting = SectionSetting::first();
    
    // Tambahkan $portfolios dan $sectionSetting ke dalam compact
    return view('welcome', compact('hero', 'services', 'portfolios', 'testimonials', 'footer', 'sectionSetting'));
});