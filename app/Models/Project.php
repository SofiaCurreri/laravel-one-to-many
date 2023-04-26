<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ["type_id", "title", "image", "text", "is_published"];

    //relazione 1(type) a N(projects) con Type
    public function type() {
        return $this->belongsTo(Type::class);
    }

    //funzione per generare un abstract del text
    public function getAbstract($max=50) {
        return substr($this->text, 0, $max) . "...";
    }

    //funzione per generare slug unico
    public static function generateSlug($title) {
        //genera slug
        $possible_slug = Str::of($title)->slug('-');

        //array di progetti in cui lo slug = $possible_slug
        $projects = Project::where('slug',  $possible_slug)->get();

        //controllo che slug sia unico e se non lo è lo rigenero
        //while finchè c' è qualcosa dentro array projects, se è vuoto (e quindi slug è unico) non entrerà nemmeno nel while
        $original_slug = $possible_slug;
        $i = 2;
        
        while(count($projects)) {
            $possible_slug = $original_slug . "-" . $i;
            $projects = Project::where('slug',  $possible_slug)->get();
            $i++;
        }

        return $possible_slug;
    }

    //funzione(mutator) per modificare formato data in cui si presenta l' updated_at
    protected function getUpdatedAtAttribute($value) {
        return date('d/m/Y H:i', strtotime($value));
    }

    //funzione(mutator) per modificare formato data in cui si presenta il created_at
    protected function getCreatedAtAttribute($value) {
        return date('d/m/Y H:i', strtotime($value));
    }

    //funzione(non mutator) per mostrare placeholder dell' immagine qualora essa non ci sia
    public function getImageUri() {
       return $this->image ? asset('storage/' . $this->image) : 'https://www.frosinonecalcio.com/wp-content/uploads/2021/09/default-placeholder.png';
    }
}