<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
		$categories = Category::all();
		return view('admin.categories.index',compact('categories'));
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
        return view('admin.categories.create');
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
		// $request è il contenuto del form (categoria)
		// @dd($request);

		// validazione category
		$this->categoryValidation($request);

		// $new_category è la nuova categoria da mettere in DB 
		$new_category = new Category;

		// generazione slug dal nome
		$new_category['slug'] = $this->slugGeneration($request->name);

		// ! aggiungo $new_category nella table categories !
		// la nuova categoria acquisisce i dati del form e viene buttato nel DB
		$data = $request->all();
		$new_category->fill($data);
		$new_category->save(); // ! DB writing here !

		// alla fine torno all'index 
		@dump('');
		return redirect()->route('admin.categories.index')->with('status','Categoria creata correttamente');		
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
			'category' => Category::find($id)
 		];
        return view('admin.categories.show',$data);
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
		// la categoria specifica
		$category = Category::find($id);

		$data = [
			'category' => $category,
		];
        return view('admin.categories.edit',$data);
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
    public function update(Request $request, Category $category)
    {
        // $request è il contenuto del form (category)
		// @dd($request);

		// $category è la categoria passata dall'edit(), quella presente in DB da modificare
		// @dd($category);

		// validazione categoria
		$this->categoryValidation($request);

		// se titolo cambiato >> rigenerazione slug
		if($request->name != $category->name) {
			$category['slug'] = $this->slugGeneration($request->name);
		}

		// ! aggiornamento $category nella table categories !
		// la category specifica acquisisce i dati del form e aggiorna quelli già presenti nel DB
		$data = $request->all();
		$category->update($data); // ! DB writing here !		

		// alla fine torno all'index 
		@dump('');
		return redirect()->route('admin.categories.index')->with('status','Categoria modificata correttamente');		
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
		// la categoria specifica in base all'id che mi hanno passato
		$category = Category::find($id);
	
        // cancellare la categoria $id
		$category->delete();

		// alla fine torno all'index 
		@dump('');
		return redirect()->route('admin.categories.index')->with('status','Categoria cancellata correttamente');		
    }








	/**
	 * Category: form data validation
	 * https://laravel.com/docs/7.x/validation
	 * errors shown in EDIT/CREATE view
	 * 
	 * @param  \Illuminate\Http\Request  $req
	 */
	protected function categoryValidation($req) {
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
		$slug_is_present = Category::where('slug',$slug)->first();
		$counter = 1;
		while ($slug_is_present) {
			$slug = $slug_tmp.'-'.$counter;
			$counter++;
			$slug_is_present = Category::where('slug',$slug)->first();
		}
		return $slug;
	}

}
