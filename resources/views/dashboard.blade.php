@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h1>{{ __('messages.dashboard') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">{{ __('messages.dashboard') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Growth Rate -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>{{ __('messages.growth_rate') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <a href="#" class="small-box-footer" onclick="event.preventDefault(); alert('{{ __('messages.feature_coming_soon') }}');">
                    {{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <!-- New Requests -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>150</h3>
                    <p>{{ __('messages.new_requests') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="#" class="small-box-footer" onclick="event.preventDefault(); alert('{{ __('messages.feature_coming_soon') }}');">
                    {{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <!-- Visitor Count -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>65</h3>
                    <p>{{ __('messages.visitor_count') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <a href="#" class="small-box-footer" onclick="event.preventDefault(); alert('{{ __('messages.feature_coming_soon') }}');">
                    {{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <!-- User Registrations -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>44</h3>
                    <p>{{ __('messages.user_registrations') }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <a href="#" class="small-box-footer" onclick="event.preventDefault(); alert('{{ __('messages.feature_coming_soon') }}');">
                    {{ __('messages.more_info') }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
