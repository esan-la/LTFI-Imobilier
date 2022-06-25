{{--@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection--}}

@extends("layouts.master")
@section("contenu")
{{--
<livewire:counter />
--}}
        
<div class="p-4">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <h1 class="display-3">Bienvenu, <strong>{{userFullName()}}</strong></h1>
            <p class="card-text">
                Some quick example text to build on the card title and make up the bulk of the card's
                content. It uses utility classes for typography and spacing to space content out within the larger container.
            </p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>
</div>
@endsection
