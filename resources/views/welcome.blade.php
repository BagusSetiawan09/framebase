@extends('layouts.app')

@section('title', 'Welcome to FrameBase - Mahakarya Visual')

@section('content')
    <x-hero :hero="$hero" />

    <x-services :services="$services" :setting="$sectionSetting" />

    <x-portfolio :portfolios="$portfolios" :setting="$sectionSetting" />

    <x-testimonial :testimonials="$testimonials" :setting="$sectionSetting" />

    <x-footer :footer="$footer" />
@endsection