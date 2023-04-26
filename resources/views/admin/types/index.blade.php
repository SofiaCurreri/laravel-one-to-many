@extends('layouts.app')

@section('title', 'Tipologie')

@section('actions')
    <a href="{{route('admin.types.create')}}" class="btn btn-primary">
        Crea nuovo tipo
    </a>
@endsection

@section('content')

    <section class="card">
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                      <th scope="col">
                        <a href="{{route('admin.types.index')}}?sort=id&order={{$sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Id
                            @if ($sort == 'id')
                                <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                            @endif
                        </a> 
                      </th>

                      <th scope="col">
                        <a href="{{route('admin.types.index')}}? sort=label&order={{$sort == 'label' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Label
                            @if ($sort == 'label')
                                <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                            @endif
                        </a>
                      </th>

                      <th scope="col">
                        <a href="{{route('admin.types.index')}}? sort=color&order={{$sort == 'color' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Colore
                            @if ($sort == 'color')
                                <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                            @endif
                        </a>
                      </th>

                      <th scope="col">
                        <a href="{{route('admin.types.index')}}? sort=color&order={{$sort == 'color' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Pill
                        </a>
                      </th>
                     
                      <th scope="col">
                        <a href="{{route('admin.types.index')}}? sort=created_at&order={{$sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Creazione
                            @if ($sort == 'created_at')
                                <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                            @endif
                        </a>
                      </th>

                      <th scope="col">
                        <a href="{{route('admin.types.index')}}? sort=updated_at&order={{$sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Ultima modifica
                            @if ($sort == 'updated_at')
                                <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                            @endif
                        </a>
                      </th>

                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($types as $type)                    
                        <tr>
                            <th scope="row">{{$type->id}}</th>
                            <td>{{$type->label}}</td>
                            <td>{{$type->color}}</td>
                            <td>
                                <span class="badge rounded-pill" style="background-color:{{$type->color}}">{{$type->label}}</span>
                            </td>
                            <td>{{$type->created_at}}</td>
                            <td>{{$type->updated_at}}</td>
                            <td class="d-flex justify-content-end">
                                {{-- <a href="{{route('admin.types.show', $type)}}">
                                    <i class="bi bi-eye mx-2"></i>
                                </a>    --}}
                                
                                <a href="{{route('admin.types.edit', $type)}}">
                                    <i class="bi bi-pencil mx-2"></i>
                                </a> 

                                <a href="#" data-bs-toggle = "modal" data-bs-target = "#delete-type-modal-{{$type->id}}">
                                    <i class="bi bi-trash text-danger mx-2"></i>
                                </a> 
                            </td>               
                        </tr>
                    @empty
                        
                    @endforelse
                  </tbody>
            </table>
        
            {{$types->links()}}
        </div>
    </section>
@endsection


@section('modals')
    @foreach ($types as $type)
        <div class="modal modal-lg fade" id="delete-type-modal-{{$type->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete-type-modal-{{$type->id}}-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-type-modal-{{$type->id}}-label">Elimina tipo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler eliminare il tipo "{{$type->title}}"? 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <form method="POST" action="{{route('admin.types.destroy', $type)}}">
                            @method('delete')
                            @csrf
                    
                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
