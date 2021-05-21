<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Post;
use App\Tag;

class PostController extends Controller
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
		$posts = Post::all();
		return view('admin.posts.index',compact('posts'));
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
		$data = [
			'tags' => Tag::all()
		];
        return view('admin.posts.create',$data);
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
		// $request è il contenuto del form (post+tag)
		// @dd($request);

		// validazione parte post
		$this->postValidation($request);

		// $new_post è il nuovo post da mettere in DB 
		$new_post = new Post;

		// generazione slug dal titolo
		$new_post['slug'] = $this->slugGeneration($request->title);

		// id user che crea il post
		$new_post['user_id'] = Auth::id();

		// il nuovo post acquisisce i dati del form e finisce nel DB
		// ! aggiornamento post tabella posts, tranne i tag !		
		$data = $request->all();
		$new_post->fill($data);
		$new_post->save(); // ! DB writing here !

		// solo con il post nel DB ho l'id del post per associare i tag
		// ! devo aggiornare la pivot associata a QUESTO post in DB!
		if($request->tags) {
			$new_post->tags()->sync($request->tags); // ! DB writing here !
		} else {
			$new_post->tags()->sync([]); // ! DB writing here !
		}

		// alla fine torno all'index 
		@dump('');
		return redirect()->route('admin.posts.index')->with('status','Post creato correttamente');		
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
			'post' => Post::find($id)
 		];
        return view('admin.posts.show',$data);
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
		// il post specifico
		$post = Post::find($id);

		// mi porto dentro tutti i tag
		// poi vedrò quale associare al post $id
		$tags = Tag::all();

		$data = [
			'post' => $post,
			'tags' => $tags
		];
        return view('admin.posts.edit',$data);
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
    public function update(Request $request, Post $post)
    {
        // $request è il contenuto del form (post+tag)
		// @dd($request);

		// validazione parte post
		$this->postValidation($request);

		// $post è il post passato dall'edit()
		// @dd($post);

		// se titolo cambiato >> rigenerazione slug
		if($request->title != $post->title) {
			$post['slug'] = $this->slugGeneration($request->title);
		}

		// ! gestire lo user che modifica il post !
		//

		// il post specifico acquisisce i dati del form e aggiorna quelli già presenti nel DB
		// ! aggiornamento post tabella posts, tranne i tag !
		$data = $request->all();
		$post->update($data); // ! DB writing here !

		// è cambiato qualcosa per i tag?
		// quali tag possiede il post non è info che sta nella tabella posts, ma nella pivot!
		// ! devo aggiornare la pivot !
		// se l'array dei tag selezionati non è vuoto
		// @dd($request->tags); // array dei tag selezionati nel form edit
		// occhio alle parentesi! (classi diverse >> metodi diversi)
		// echo '$post->tags()'; @dump($post->tags()); 	// BelongsToMany >> relazione post-tag >> tag associati al $post
		// echo '$post->tags'; @dd($post->tags); 		// Collection di Model Tag >> tag associati al $post
		// qui uso $post->tags() e non $post->tags (classi diverse >> metodi diversi)
		if($request->tags) {
			$post->tags()->sync($request->tags); // ! DB writing here !
		} else {
			$post->tags()->sync([]); // ! DB writing here !
		}

		// alla fine torno all'index 
		@dump('');
		return redirect()->route('admin.posts.index')->with('status','Post aggiornato correttamente');		
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
		// il post specifico in base all'id che mi hanno passato
		$post = Post::find($id);
		
		// cancellare le relazioni post(id)-tag presenti nella pivot
		$post->tags()->sync([]);

        // cancellare il post $id
		$post->delete();

		// alla fine torno all'index 
		@dump('');
		return redirect()->route('admin.posts.index')->with('status','Post cancellato correttamente');		
    }








	/**
	 * Post: form data validation
	 * https://laravel.com/docs/7.x/validation
	 * errors shown in EDIT/CREATE view
	 * 
	 * @param  \Illuminate\Http\Request  $req
	 */
	protected function postValidation($req) {
		$req->validate([
			'title'		=> 'required|max:255',
			'content'	=> 'required'
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
		$slug_is_present = Post::where('slug',$slug)->first();
		$counter = 1;
		while ($slug_is_present) {
			$slug = $slug_tmp.'-'.$counter;
			$counter++;
			$slug_is_present = Post::where('slug',$slug)->first();
		}
		return $slug;
	}

}
