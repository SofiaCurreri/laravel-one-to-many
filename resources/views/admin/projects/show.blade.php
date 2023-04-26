@extends('layouts.app')

@section('title', $project->title)

@section('actions')
    <a href="{{route('admin.projects.index')}}" class="btn btn-primary float-end mx-2">Torna alla lista</a>
    <a href="{{route('admin.projects.edit', $project)}}" class="btn btn-primary float-end mx-2">Modifica progetto</a>   
@endsection

@section('content')
    <section class="card clearfix">
        <div class="card-body">
            <p>
                <strong>Tipo: </strong>
                {{$project->type?->label}}
            </p>

            {{-- Il '?' equivale a "Se c' è un tipo allora mostrami il suo "label" --}}
            {{-- @dump($project->type?->label) --}}

            <figure class="float-end ms-5 mb-3">
                {{-- asset() parte di default da public --}}
                <img src="{{$project->getImageUri()}}" alt="{{$project->slug}}" width="300px">
                <figcaption class="text-muted text-secondary m-0">
                    {{$project->slug}}
                </figcaption>
            </figure>
            <p>
                <strong>Contenuto: </strong>
                {{$project->text}}
            </p>
        </div>
        
    </section>
@endsection