@extends('layouts.app')

@section('title', ($project->id) ? 'Modifica progetto' : 'Crea un nuovo progetto')

@section('actions')
    <a href="{{route('admin.projects.index')}}" class="btn btn-primary">
        Torna alla lista
    </a>
@endsection

@section('content')

    @include('layouts.partials.errors')

    <section class="card">
        <div class="card-body">

            {{-- Form unico per edit e create --}}
            {{-- Se project ha già un id sarà una modifica (if(...)), se non ce l' ha è una creazione (else...) (per distinguere i due casi) --}}
            @if($project->id)
                <form method="POST" action="{{route('admin.projects.update', $project)}}" enctype="multipart/form-data" class="row">
                    @method('PUT')
            @else 
            {{-- con enctype="multipart/form-data" il form ha il permesso di inviare file --}}
                <form method="POST" action="{{route('admin.projects.store')}}" enctype="multipart/form-data" class="row">
            @endif
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2 text-end">
                            <label for="title" class="form-label">Titolo</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title', $project->title)}}"> 
                            @error('title')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>                                    
                            @enderror
                        </div>
                    </div> 

                    <div class="row mb-3">
                        <div class="col-md-2 text-end">
                            <label for="type_id" class="form-label">Categoria</label>
                        </div>
                        <div class="col-md-10">
                            <select name="type_id" id="type_id" class="form-select @error('type_id') is-invalid @enderror">
                                <option value="">Non categorizzato</option>
                                @foreach ($types as $type)                      
                                    <option @if(old('type_id', $project->type_id) == $type->id) selected @endif value="{{$type->id}}">{{$type->label}}</option>
                                @endforeach
                              </select>

                              @error('type_id')
                                  <div class="invalid-feedback">
                                    {{$message}}
                                  </div>
                              @enderror
                        </div>
                    </div> 

                    <div class="row mb-3">
                        <div class="col-md-2 text-end">
                            <label for="is_published" class="form-label">Pubblicato</label>
                        </div>
                        <div class="col-md-10">
                            <input type="checkbox" name="is_published" id="is_published" class="form-check-input @error('is_published') is-invalid @enderror" @checked(old('is_published', $project->is_published)) value="1"> 
                            @error('is_published')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>                                    
                            @enderror
                        </div>
                    </div> 
                        
                    <div class="row mb-3">
                        <div class="col-md-2 text-end">
                            <label for="image" class="form-label">Immagine</label>
                        </div>
                        <div class="col-md-8">
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>                                    
                            @enderror
                        </div>
                        <div class="col-2">
                            <img src="{{$project->getImageUri()}}" class="img-fluid" alt="" id="image-preview">
                        </div>
                    </div>
                        
                    <div class="row mb-3">
                        <div class="col-md-2 text-end">
                            <label for="text" class="form-label">Testo</label>
                        </div>
                        <div class="col-md-10">
                            <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror" rows="5">
                                {{old('text', $project->text)}}
                            </textarea>
                            @error('text')
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


{{-- Per anteprima immagini --}}
@section('scripts')
    <script>
        const imageInputEl = document.getElementById('image');
        const imagePreviewEl = document.getElementById('image-preview');

        //cosi se non carico alcuna immagine nuova vedo quella che c' era prima
        const placeholder = imagePreviewEl.src;

        imageInputEl.addEventListener('change', () => {
            if(imageInputEl.files && imageInputEl.files[0]) {
                
                //classe che si trova gia dentro javascript e che permette di effettuare operazioni sui file selezionati
                const reader = new FileReader();

                //readAsDataURL() metodo che encoderà un' immagine direttamente dentro tag src
                reader.readAsDataURL(imageInputEl.files[0]);

                reader.onload = e => {
                    imagePreviewEl.src = e.target.result;
                }
            } else  imagePreviewEl.src = placeholder;
        })
    </script>
@endsection