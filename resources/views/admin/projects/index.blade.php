@extends('layouts.app')

@section('title', 'Projects')

@section('actions')
    <a href="{{route('admin.projects.create')}}" class="btn btn-primary">
        Crea nuovo progetto
    </a>

    <a href="{{route('admin.projects.trash')}}" class="btn btn-secondary">
        Cestino
    </a>
@endsection

@section('content')

    <section class="card">
        <div class="card-body">

            <table class="table table-striped">
                <thead>
                    <tr>
                      <th scope="col">
                        <a href="{{route('admin.projects.index')}}?sort=id&order={{$sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Id
                            @if ($sort == 'id')
                                <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                            @endif
                        </a> 
                      </th>

                      
                      <th scope="col">
                          <a href="{{route('admin.projects.index')}}? sort=title&order={{$sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Titolo
                            @if ($sort == 'title')
                            <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                            @endif
                        </a>
                      </th>
                       
                      <th scope="col">
                        Tipo
                      </th>
                      
                      <th scope="col">
                        <a href="{{route('admin.projects.index')}}? sort=text&order={{$sort == 'text' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Abstract
                            @if ($sort == 'text')
                                <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                            @endif
                        </a>
                      </th>
                     
                      <th scope="col">
                        <a href="{{route('admin.projects.index')}}? sort=created_at&order={{$sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Creazione
                            @if ($sort == 'created_at')
                                <i class="bi bi-arrow-down d-inline-block @if ($order == 'DESC') rotate-180 @endif"></i>
                            @endif
                        </a>
                      </th>

                      <th scope="col">
                        <a href="{{route('admin.projects.index')}}? sort=updated_at&order={{$sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
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
                    @forelse ($projects as $project)                    
                        <tr>
                            <th scope="row">{{$project->id}}</th>
                            <td>{{$project->title}}</td>
                            <td>{{$project->type?->label}}</td>
                            <td>{{$project->getAbstract(20)}}</td>
                            <td>{{$project->created_at}}</td>
                            <td>{{$project->updated_at}}</td>
                            <td class="d-flex justify-content-end">
                                <a href="{{route('admin.projects.show', $project)}}">
                                    <i class="bi bi-eye mx-2"></i>
                                </a>   
                                
                                <a href="{{route('admin.projects.edit', $project)}}">
                                    <i class="bi bi-pencil mx-2"></i>
                                </a> 

                                <a href="{{route('admin.projects.destroy', $project)}}" data-bs-toggle = "modal" data-bs-target = "#delete-project-modal-{{$project->id}}">
                                    <i class="bi bi-trash text-danger mx-2"></i>
                                </a> 
                            </td>               
                        </tr>
                    @empty
                        
                    @endforelse
                  </tbody>
            </table>
        
            {{$projects->links()}}
        </div>
    </section>
@endsection


@section('modals')
    @foreach ($projects as $project)
        <div class="modal modal-lg fade" id="delete-project-modal-{{$project->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete-project-modal-{{$project->id}}-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-project-modal-{{$project->id}}-label">Delete project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Sei sicuro di voler eliminare il progetto "{{$project->title}}"? 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <form method="POST" action="{{route('admin.projects.destroy', $project)}}">
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
