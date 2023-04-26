@extends('layouts.app')

@section('title', $type->label)

@section('actions')
    <a href="{{route('admin.types.index')}}" class="btn btn-primary float-end mx-2">Torna alla lista</a>
    <a href="{{route('admin.types.edit', $type)}}" class="btn btn-primary float-end mx-2">Modifica tipo</a>   
@endsection

@section('content')
    <section class="card clearfix">
        <div class="card-body">
            <p>
                <strong>Tipo: </strong>
                <span class="badge rounded-pill" style="background-color:{{$type->color}}">{{$type->label}}</span>
            </p>
        </div>
        
    </section>
@endsection