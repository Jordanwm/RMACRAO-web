<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Speaker;

use Illuminate\Http\Request;

class SpeakersController extends Controller {

	// Add Authorization requirements
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('speakers.index', ['speakers' => Speaker::all()]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('speakers.create', ['speakers' => new Speaker]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//Create a speaker
		$speaker = new Speaker;

		if($this->saveInput($request, $speaker)){
			return redirect('speakers')->with('message', "Successfully added" . $speaker->name);
		} else {
			return redirect()->back()->withInput()->with('error', "Please fill in all the form inputs.");
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return view('speakers.edit', ['speaker' => Speaker::findOrFail($id)]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		//Update a speaker
		$speaker = Speaker::findOrFail($id);

		if($this->saveInput($request, $speaker)){
			return redirect('speakers')->with('message', "Successfully updated" . $speaker->name);
		} else {
			return redirect()->back()->withInputs()->with('error', "Please fill in all the form inputs.");
		}
	}

	public function delete($id) {
		return view('speakers.delete', ['speaker'=> Speaker::findOrFail($id)]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		Speaker::find($id)->delete();
		return redirect('speakers');
	}

	private function saveInput($request, $speaker) {
		if ($request->input('name') == '' || $request->input('session') == '' || 
				$request->input('day') == '' || $request->input('time') == '' ||
				$request->input('location') == '' || $request->input('title') == '') {
			return false;
		}

		//insert the data
		$speaker->name = $request->input('name');
		$speaker->session = $request->input('session');
		$speaker->day = $request->input('day');
		$speaker->time = $request->input('time');
		$speaker->location = $request->input('location');
		$speaker->title = $request->input('title');

		//save the new speaker
		$speaker->save();
		return true;

	}

}
