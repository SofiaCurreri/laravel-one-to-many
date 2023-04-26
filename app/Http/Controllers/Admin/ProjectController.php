<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Type;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         //riga sotto = "Se nell' url c' è richiesta di ordinare per qualcosa, ordina per quello, altrimenti di default usa updated_at"
         $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at";

         //se nella richiesta ho un qualche tipo di ordine usa quello, altrimenti ordina in modo discendente
         $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC";

         //con withQueryString() vengono mantenuti i parametri nell' url, quindi il sort continua a produrre effetto anche se cambi pagina usando tasti paginazione
         $projects = Project::orderBy($sort, $order)->paginate(10)->withQueryString();
         return view('admin.projects.index', compact('projects', 'sort', 'order')); //percorso cartelle

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $project = new Project;
        $types = Type::orderBy('label')->get();        
        return view('admin.projects.form', compact('project', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validation
        $request->validate([
            'title' => 'required|string|max:100',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'is_published' => 'boolean',
            'type_id' => 'nullable|exists:types,id'
        ], 
        [
            'title.required' => 'Il titolo è obbligatorio',
            'title.string' => 'Il titolo deve essere una stringa',
            'title.max' => 'Il titolo può avere 100 caratteri al massimo',

            'text.required' => 'Il contenuto è obbligatorio',
            'text.string' => 'Il contenuto deve essere una stringa',

            'image.image' => 'Il file caricato deve essere un\'immagine',
            'image.mimes' => 'Le estensioni accettate per l\' immagine sono jpg, png, jpeg',

            'type_id.exists' => 'L\' id della categoria non è valido'
        ]);

        $data = $request->all(); //per non scrivere $request->all() per intero ogni volta

        if(Arr::exists($data, 'image')) { //$data = array mentre 'image' = chiave che stai cercando
            $path = Storage::put('uploads/projects', $data['image']); //Metti in public/storage/uploads/projects l' immagine che riceviamo
            $data['image'] = $path; //METODO 2, nella chiave 'image' mettici il $path che hai appena salvato alla riga sopra
        }
        
        $project = new Project;
        $project->fill($data);
        $project->slug = Project::generateSlug($project->title);
        // $project->image = $path; METODO 1
        $project->save();

        return to_route('admin.projects.show',$project)
            ->with('message_content', 'Post creato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::orderBy('label')->get();
        return view('admin.projects.form', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //validation
        $request->validate([
            'title' => 'required|string|max:100',
            'text' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'is_published' => 'boolean',
            'type_id' => 'nullable|exists:types,id'
        ], 
        [
            'title.required' => 'Il titolo è obbligatorio',
            'title.string' => 'Il titolo deve essere una stringa',
            'title.max' => 'Il titolo può avere 100 caratteri al massimo',

            'text.required' => 'Il contenuto è obbligatorio',
            'text.string' => 'Il contenuto deve essere una stringa',

            'image.image' => 'Il file caricato deve essere un\'immagine',
            'image.mimes' => 'Le estensioni accettate per l\' immagine sono jpg, png, jpeg',

            'type_id.exists' => 'L\' id della categoria non è valido'
        ]);

        $data = $request->all(); //per non scrivere $request->all() per intero ogni volta
        $data["slug"] = Project::generateSlug($data["title"]);
        $data["is_published"] = $request->has("is_published") ? 1 : 0;

        if(Arr::exists($data, 'image')) { //$data = array mentre 'image' = chiave che stai cercando

            //se progetto ha gia un' immagine, nel modificarlo, cancellala, per sostituirla con la nuova, MA SOLO SE ne è stata inviata una nuova
            if($project->image) Storage::delete($project->image); 

            //Metti in public/storage/uploads/projects l' immagine che riceviamo
            $path = Storage::put('uploads/projects', $data['image']); 

            //METODO 2, nella chiave 'image' mettici il $path che hai appena salvato alla riga sopra
            $data['image'] = $path; 
        }
        
        //update() = fill() + save()
        $project->update($data);

        //return to_route = redirect
        return to_route('admin.projects.show', $project)
            ->with('message_content', 'Post modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $id_project = $project->id;

        //quando cancelliamo progetto dobbiamo cancellare anche relativa immagine
        // if($project->image) Storage::delete($project->image);
        
        $project->delete();
        return to_route('admin.projects.index')
            ->with('message_type', "danger")
            ->with('message_content', "Post $id_project spostato nel cestino"); // <= per la flesh session
    }


    /**
     * Display a listing of the trashed resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request) {
        $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at";
        $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC";
        $projects = Project::onlyTrashed()->orderBy($sort, $order)->paginate(10)->withQueryString();
 
        return view('admin.projects.trash', compact('projects', 'sort', 'order') );
    }

     /**
     * Force delete the specified resource from storage.
     * Force delete elimina riga da database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Int $id)
    {
        $project = Project::where('id', $id)->onlyTrashed()->first();

        //quando cancelliamo progetto dobbiamo cancellare anche relativa immagine
        if($project->image) Storage::delete($project->image);
        
        $project->forceDelete();
        
        return to_route('admin.projects.trash')
            ->with('message_type', "danger")
            ->with('message_content', "Post $id eliminato definitivamente"); // <= per la flesh session
    }

    
    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Int $id)
    {
        $project = Project::where('id', $id)->onlyTrashed()->first();

        //setta NULL la data di cancellazione
        $project->restore();
        
        return to_route('admin.projects.index')
            ->with('message_content', "Post $id ripristinato correttamente"); // <= per la flesh session
    }
}