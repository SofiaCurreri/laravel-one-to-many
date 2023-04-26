@extends('layouts.app')

@section('title', ($type->id) ? 'Modifica tipo' : 'Crea un nuovo tipo')

@section('actions')
    <a href="{{route('admin.types.index')}}" class="btn btn-primary">
        Torna alla lista
    </a>
@endsection

@section('content')

    @include('layouts.partials.errors')

    <section class="card">
        <div class="card-body">

            {{-- Form unico per edit e create --}}
            {{-- Se project ha già un id sarà una modifica (if(...)), se non ce l' ha è una creazione (else...) (per distinguere i due casi) --}}
            @if($type->id)
                <form method="POST" action="{{route('admin.types.update', $type)}}" enctype="multipart/form-data" class="row">
                    @method('PUT')
            @else 
            {{-- con enctype="multipart/form-data" il form ha il permesso di inviare file --}}
                <form method="POST" action="{{route('admin.types.store')}}" enctype="multipart/form-data" class="row">
            @endif
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2 text-end">
                            <label for="label" class="form-label">Label</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="label" id="label" class="form-control @error('label') is-invalid @enderror" value="{{old('label', $type->label)}}"> 
                            @error('label')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>                                    
                            @enderror
                        </div>
                    </div> 

                    <div class="row mb-3">
                        <div class="col-md-2 text-end">
                            <label for="color" class="form-label">Colore</label>
                        </div>
                        <div class="col-md-10">
                            <input type="color" name="color" id="color" class="form-control @error('color') is-invalid @enderror" value="{{old('color', $type->color)}}"> 
                            @error('color')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>                                    
                            @enderror
                        </div>
                    </div> 

                    <div class="row">
                        <div class="m-auto col-8 mb-3">
                            <input type="submit" class="btn btn-primary mt-4" value="Salva"> 
                        </div>
                    </div>
                </form>          
        </div>
    </section>
@endsection
