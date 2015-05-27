<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Day;
use App\Session;
use App\Event;
use App\Presenter;
use App\Facilitator;
use Log;

use Illuminate\Http\Request;

class SessionsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//$days = Day::with('sessions', 'sessions.events')->get();
		return view('sessions.index');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$data = $request->input();
		$day = new Day;
		$day->day = $data['day'];
		$day->save();
		return json_encode($day->toArray());
	}

	public function createSession(Request $request, $id){
		$data = $request->input();

		$day = Day::findOrFail($id);
		$session = new Session;
		
		$session->name = $data['name'];
		$session->time = $data['time'];
		
		$day->sessions()->save($session);
		return json_encode($session->toArray());
	}

	public function createEvent(Request $request, $dayId, $sessionId) {
		$data = $request->input();
		$presenters = [];
		$facilitators = [];
		
		$event = new Event;
		$event->title = $data['title'];
		$event->sid = $data['sid'];
		$event->description = $data['description'];
		$event->sponser = $data['sponser'];
		$event->location = $data['location'];
		$event->save();
		
		foreach( $data['presenters'] as $presenter) {
			$p = new Presenter;
			$p->name = $presenter['name'];
			$p->school = $presenter['school'];
			$p->event_id = $event->id;
			$p->save();
		}

		foreach( $data['facilitators'] as $facilitator) {
			$f = new Facilitator;
			$f->name = $facilitator['name'];
			$f->school = $facilitator['school'];
			$f->event_id = $event->id;
			$f->save();
		}

		
		$session = Session::findOrFail($sessionId);
		$session->events()->save($event);

		$e = Event::with('presenters', 'facilitators')->find($event->id);

		return json_encode($e->toArray());
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
		Log::Info($data);
		$day = Day::findOrFail($id);
		$day->day = $data['day'];
		$day->save();

		return json_encode($day->toArray());
	}

	public function updateSession(Request $request, $dayId, $sessionId) {
		$data = $request->input();

		$session = Session::findOrFail($sessionId);

		$session->name = $data['name'];
		$session->time = $data['time'];

		$session->save();
		return json_encode($session->toArray());
	}

	public function updateEvent(Request $request, $dayId, $sessionId, $eventId) {
		$data = $request->input();
		
		$event = Event::findOrFail($eventId);
		$event->title = $data['title'];
		$event->sid = $data['sid'];
		$event->description = $data['description'];
		$event->sponser = $data['sponser'];
		$event->location = $data['location'];
		$event->save();
		
		//If we have the same number of presenters, just rename the current ones
		if(sizeof($data['presenters']) == sizeof($event->presenters()->get())){
			foreach( $event->presenters()->get() as $key=>$presenter) {
				$presenter->name = $data['presenters'][$key]['name'];
				$presenter->school = $data['presenters'][$key]['school'];
				$presenter->save();
			}
		}

		//If we just added another presenter (or more) replace what we have and then add more
		if(sizeof($data['presenters']) > sizeof($event->presenters()->get())){
			$current_key = 0;
			foreach( $event->presenters()->get() as $key=>$presenter) {
				$presenter->name = $data['presenters'][$key]['name'];
				$presenter->school = $data['presenters'][$key]['school'];
				$presenter->save();
				$current_key = $key;
			}
			for ($current_key; $current_key < sizeof($data['presenters']); $current_key++){
				$p = new Presenter;
				$p->name = $data['presenters'][$current_key]['name'];
				$p->school = $data['presenters'][$current_key]['school'];
				$p->event_id = $event->id;
				$p->save();
			}
		}

		//If we have removed a presenter (or more) change names as needed and delete the rest
		if(sizeof($data['presenters']) < sizeof($event->presenters()->get())){
			$current_key = 0;
			$presenters = $event->presenters()->get();
			foreach( $data['presenters'] as $key=>$presenter) {
				$presenters[$key]->name = $presenter['name'];
				$presenters[$key]->school = $presenter['school'];
				$presenters[$key]->save();
				$current_key = $key;
			}

			//Add one to skip the last record we updated.
			$current_key++;
			for ($current_key; $current_key < sizeof($presenters); $current_key++){
				$presenters[$current_key] -> delete();
			}
		}

		//If we have the same number of presenters, just rename the current ones
		if(sizeof($data['facilitators']) == sizeof($event->facilitators()->get())){
			foreach( $event->facilitators()->get() as $key=>$facilitator) {
				$facilitator->name = $data['facilitators'][$key]['name'];
				$facilitator->school = $data['facilitators'][$key]['school'];
				$facilitator->save();
			}
		}

		//If we just added another presenter (or more) replace what we have and then add more
		if(sizeof($data['facilitators']) > sizeof($event->facilitators()->get())){
			$current_key = 0;
			foreach( $event->facilitators()->get() as $key=>$facilitator) {
				$facilitator->name = $data['facilitators'][$key]['name'];
				$facilitator->school = $data['facilitators'][$key]['school'];
				$facilitator->save();
				$current_key = $key;
			}
			for ($current_key; $current_key < sizeof($data['facilitators']); $current_key++){
				$f = new Facilitator;
				$f->name = $data['facilitators'][$current_key]['name'];
				$f->school = $data['facilitators'][$current_key]['school'];
				$f->event_id = $event->id;
				$f->save();
			}
		}

		//If we have removed a presenter (or more) change names as needed and delete the rest
		if(sizeof($data['facilitators']) < sizeof($event->facilitators()->get())){
			$current_key = 0;
			$facilitators = $event->facilitators()->get();
			foreach( $data['facilitators'] as $key=>$facilitator) {
				$facilitators[$key]->name = $facilitator['name'];
				$facilitators[$key]->school = $facilitator['school'];
				$facilitators[$key]->save();
				$current_key = $key;
			}

			//Add one to skip the last record we updated.
			$current_key++;
			for ($current_key; $current_key < sizeof($facilitators); $current_key++){
				$facilitators[$current_key] -> delete();
			}
		}
		
		$e = Event::with('presenters', 'facilitators')->find($eventId);

		return json_encode($e->toArray());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{		
		$day = Day::findOrFail($id);
		foreach($day->sessions() as $session){
			foreach ($session->events() as $event){
				$event->presenters()->delete();
				$event->facilitators()->delete();
			}
			$session->events()->delete();
		}
		$day->delete();

		return json_encode($day->toArray());	
	}

	public function destroySession(Request $request, $dayId, $sessionId){
		$session = Session::findOrFail($sessionId);
		foreach ($session->events() as $event){
			$event->presenters()->delete();
			$event->facilitators()->delete();
		}
		$session->events()->delete();
		$session->delete();

		return json_encode($session->toArray());
	}

	public function destroyEvent(Request $request, $dayId, $sessionId, $eventId){
		$event = Event::findOrFail($eventId);
		$event->presenters()->delete();
		$event->facilitators()->delete();
		$event->delete();
		
		return json_encode($event->toArray());
	}

}
