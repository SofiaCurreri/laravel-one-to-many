@extends('layouts.guest')
@section('content')

<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h2>Progetti più recenti</h2>
                </div>

                <div class="card-body">
                  @dump($recent_projects)
                </div>
            </div>
        </div>
    </div>
</div>
@endsection