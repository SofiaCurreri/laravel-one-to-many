<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : "updated_at";
        $order = (!empty($order_request = $request->get('order'))) ? $order_request : "DESC";
        $types = Type::orderBy($sort, $order)->paginate(10)->withQueryString();

        return view('admin.types.index', compact('types', 'sort', 'order'));
    }


    /**
     * Show the form for creating the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = new Type();
        return view('admin.types.form', compact('type')); 
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:20',
            'color' => 'required|string|size:7',
        ], [
            'label.required' => 'La label è obbligatoria',
            'label.string' => 'La label deve essere una stringa',
            'label.max' => 'La label può avere al massimo 20 caratteri',

            'color.required' => 'Il colore è obbligatorio',
            'color.string' => 'Il colore deve essere una stringa',
            'colorsize' => 'Il colore deve essere di 7 caratteri',
        ]);

        $type = new Type();
        $type->fill($request->all());
        $type->save();

        return to_route('admin.types.index')
            ->with('message_content', "Tipo $type->id creato con successo");
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return view('admin.types.index', compact('type'));
    }

    /**
     * Show the form for editing the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        return view('admin.types.form', compact('type'));
    }

    /**
     * Update the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        $request->validate([
            'label' => 'required|string|max:20',
            'color' => 'required|string|size:7',
        ], [
            'label.required' => 'La label è obbligatoria',
            'label.string' => 'La label deve essere una stringa',
            'label.max' => 'La label può avere al massimo 20 caratteri',

            'color.required' => 'Il colore è obbligatorio',
            'color.string' => 'Il colore deve essere una stringa',
            'colorsize' => 'Il colore deve essere di 7 caratteri',
        ]);

        $type->update($request->all());

        return to_route('admin.types.index')
            ->with('message_type', "danger")
            ->with('message_content', "Tipo $type->id modificato con successo");
    }

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type_id = $type->id;
        $type->delete();

        return to_route('admin.types.index')
            ->with('message_content', "Tipo $type->id eliminato con successo");
    }
}