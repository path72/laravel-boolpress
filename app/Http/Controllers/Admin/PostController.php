<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Tag;

class PostController extends Controller
{
    /**
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
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
        // $request è il contenuto del form
		// @dd($request);

		// $post è il post passato dall'edit()
		// @dd($post);

		// validazione
		$this->postValidation($request);

		// il post specifico acquisisce i dati del form
		// ! aggiornamento post tabella posts, tranne i tag !
		$data = $request->all();
		$post->update($data);

		// è cambiato qualcosa per i tag?
		// quali tag possiede il post non è info che sta nella tabella posts, ma nella pivot!
		// ! devo aggiornare la pivot !
		// se l'array dei tag selezionati non è vuoto
		// @dd($request->tags); // array dei tag selezionati nel form edit
		// @dd($post->tags()); 	// relazione post-tag (i tag di questo post)
		if($request->tags) {
			$post->tags()->sync($request->tags);
		} else {
			$post->tags()->sync([]);
		}

		// alla fine torno all'index 
		@dump('');
		return redirect()->route('admin.posts.index')->with('status','Post aggiornato correttamente');		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }








	/**
	 * Post: form data validation
	 * https://laravel.com/docs/7.x/validation
	 * errors shown in EDIT/CREATE view
	 */
	protected function postValidation($req) {
		$req->validate([
			'title'		=> 'required|max:255',
			'content'	=> 'required'
		]);
	}




}
