<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Tag;

class TagController extends Controller
{
    /**
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * %             INDEX             %
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$tags = Tag::all();
		return view('admin.tags.index',compact('tags'));
    }

    /**
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * %            CREATE             %
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * 
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * %             STORE             %
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * 
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// $request è il contenuto del form (tag)
		// @dd($request);

		// validazione category
		$this->tagValidation($request);

		// $new_tag è il nuovo tag da mettere in DB 
		$new_tag = new Tag;

		// generazione slug dal nome
		$new_tag['slug'] = $this->slugGeneration($request->name);

		// ! aggiungo $new_tag nella table tags !
		// il nuovo tag acquisisce i dati del form e viene buttato nel DB
		$data = $request->all();
		$new_tag->fill($data);
		$new_tag->save(); // ! DB writing here !

		// alla fine torno all'index 
		@dump('');
		return redirect()->route('admin.tags.index')->with('status','Tag creato correttamente');		
    }

    /**
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * %             SHOW              %
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * 
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$data = [
			'tag' => Tag::find($id)
 		];
        return view('admin.tags.show',$data);
        //
    }

    /**
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * %             EDIT              %
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * 
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		// il tag specifico
		$tag = Tag::find($id);

		$data = [
			'tag' => $tag,
		];
        return view('admin.tags.edit',$data);
    }

    /**
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * %            UPDATE             %
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * 
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        // $request è il contenuto del form (tag)
		// @dd($request);

		// $tag è il tag passato dall'edit(), quello presente in DB da modificare
		// @dd($tag);

		// validazione categoria
		$this->tagValidation($request);

		// se titolo cambiato >> rigenerazione slug
		if($request->name != $tag->name) {
			$tag['slug'] = $this->slugGeneration($request->name);
		}

		// ! aggiornamento $tag nella table tags !
		// il tag specifico acquisisce i dati del form e aggiorna quelli già presenti nel DB
		$data = $request->all();
		$tag->update($data); // ! DB writing here !		

		// alla fine torno all'index 
		@dump('');
		return redirect()->route('admin.tags.index')->with('status','Tag modificato correttamente');		
    }

    /**
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * %            DESTROY            %
	 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	 * 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		// il tag specifico in base all'id che mi hanno passato
		$tag = Tag::find($id);
	
        // cancellare il tag $id
		$tag->delete();

		// alla fine torno all'index 
		@dump('');
		return redirect()->route('admin.tags.index')->with('status','Tag eliminato correttamente');		
    }






	/**
	 * Tag: form data validation
	 * https://laravel.com/docs/7.x/validation
	 * errors shown in EDIT/CREATE view
	 * 
	 * @param  \Illuminate\Http\Request  $req
	 */
	protected function tagValidation($req) {
		$req->validate([
			'name'			=> 'required|max:255',
			'description'	=> 'required'
		]);
	}

	/**
	 * Creazione slug a partire da stringa sorgente
	 * deve essere unico nellla tabella posts
	 * 
	 * @param string $slug_source
	 * @return string
	 */
	protected function slugGeneration($slug_source) {
		$slug = Str::slug($slug_source,'-');
		$slug_tmp = $slug;
		$slug_is_present = Tag::where('slug',$slug)->first();
		$counter = 1;
		while ($slug_is_present) {
			$slug = $slug_tmp.'-'.$counter;
			$counter++;
			$slug_is_present = Tag::where('slug',$slug)->first();
		}
		return $slug;
	}

}
