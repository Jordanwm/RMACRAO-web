<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Exhibitor;
use App\Staff;
use Log;

use Illuminate\Http\Request;

class ExhibitorsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('exhibitors.index', ['exhibitors' => Exhibitor::all()]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('exhibitors.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$data = $request->input();
		
		$exhibitor = new Exhibitor;
		$exhibitor->name = $data['name'];
		$exhibitor->description = $data['description'];
		$exhibitor->zip = $data['zip'];
		$exhibitor->state = $data['state'];
		$exhibitor->city = $data['city'];
		$exhibitor->address = $data['address'];
		$exhibitor->save();

		$staff = [];
		foreach($data['staff'] as $s) {
			$stf = new Staff;
			$stf->name = $s['name'];
			$stf->title = $s['title'];
			$stf->exhibitor()->associate($exhibitor);
			$stf->save();
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
		return view('exhibitors.show', ['exhibitor' => Exhibitor::findOrFail($id)]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return view('exhibitors.edit', ['exhibitor' => Exhibitor::with('staff')->findOrFail($id)]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$data = $request->input();
		
		$exhibitor = Exhibitor::findOrFail($id);
		$exhibitor->name = $data['name'];
		$exhibitor->description = $data['description'];
		$exhibitor->zip = $data['zip'];
		$exhibitor->state = $data['state'];
		$exhibitor->city = $data['city'];
		$exhibitor->address = $data['address'];
		$exhibitor->save();

		$current_staff = $exhibitor->staff()->get();

		//If we have the same number of staff, just rename the current ones
		if(sizeof($data['staff']) == sizeof($current_staff)){
			foreach( $current_staff as $key=>$s) {
				$s->name = $data['staff'][$key]['name'];
				$s->title = $data['staff'][$key]['title'];
				$s->save();
			}
		}

		//If we just added another staff (or more) replace what we have and then add more
		if(sizeof($data['staff']) > sizeof($current_staff)){
			$current_key = 0;
			foreach( $current_staff as $key=>$s) {
				$s->name = $data['staff'][$key]['name'];
				$s->title = $data['staff'][$key]['title'];
				$s->save();
				$current_key = $key;
			}
			for ($current_key; $current_key < sizeof($data['staff']); $current_key++){
				$s = new Staff;
				$s->name = $data['staff'][$current_key]['name'];
				$s->title = $data['staff'][$current_key]['title'];
				$s->exhibitor_id = $exhibitor->id;
				$s->save();
			}
		}

		//If we have removed a presenter (or more) change names as needed and delete the rest
		if(sizeof($data['staff']) < sizeof($current_staff)){
			$current_key = 0;
			foreach( $data['staff'] as $key=>$s) {
				$current_staff[$key]->name = $s['name'];
				$current_staff[$key]->title = $s['title'];
				$current_staff[$key]->save();
				$current_key = $key;
			}

			//Add one to skip the last record we updated.
			$current_key++;
			for ($current_key; $current_key < sizeof($current_staff); $current_key++){
				$current_staff[$current_key]->delete();
			}
		}

		return json_encode($exhibitor);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$exhibitor = Exhibitor::findOrFail($id);
		$exhibitor->staff()->delete();
		$exhibitor->delete();

		return json_encode($exhibitor);
	}

}
