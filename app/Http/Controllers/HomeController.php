<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead;
use App\Mail\SendNewMail;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
	
	// ! HERE [4] !
	/**
	 * no __construct() with middleware('auth')
	 * (middleware('auth') in routes)
	 */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('guest.home');
    }

    /**
     * Show the contact form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact()
    {
        return view('guest.contact_form');
    }

    /**
	 * Method called by from action
	 * 
     * Store contact form data to DB.
	 * Send email to commerciale@boolpress.it
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contactSent(Request $request)
    {
		// conservo dati form in tabella DB leads
		$form_data = $request->all();
		$new_lead = new Lead();
		$new_lead->fill($form_data);
		$new_lead->save();

		// invio email notifica del contatto
		Mail::to('commerciale@boolpress.it')
			->send(new SendNewMail($new_lead));

		// torno a view contatti
		return redirect()->route('contact')->with('status','Messaggio inviato correttamente');

		// @dd($request);
		// return 'ciao contatti';
    }
}
