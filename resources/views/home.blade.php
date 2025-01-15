<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'eLearning')

@section('content')
<h1>Welcome to the eLearning Page</h1>
<p>This is the content for the eLearning page.</p>

<div>
    <p>This is the content for the eLearning page.</p>
    <p>This is the content for the eLearning page.</p>

    <a href="url_to_profile_page">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
        <span>Mi Perfil</span>
    </a>
</div>

@endsection