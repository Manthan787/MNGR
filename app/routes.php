<?php

Route::get('/', function()
{
	return View::make('Admin.index');
});


Route::post('form','UserController@store');

Route::get('/ang',function(){
		return View::make('Admin.index');
	});
#Till the AUTH is in place, then this will be gone.
//Auth::login(User::find(1));
//Auth::logout();

Route::post('api/auth/login', 'AuthController@login');
Route::get('api/auth/logout','AuthController@logout');


#API ROUTES
Route::group(['before'=>'teacher'],function(){

	#Questions
	Route::get('api/Questions/all','QuestionController@getAll');
	Route::post('api/Questions/add','QuestionController@postQuestion');
	Route::get('api/Questions/{id}','QuestionController@getById');

});

Route::get('/h',function(){

	$date = DateTime::createFromFormat('d/m/Y','15/09/1993')->format('Y-m-d');
	echo $date;
});

Route::group(['before'=>'teacher'],function(){

	Route::get('api/Students/all','StudentController@getAll');
	Route::post('api/Students/add','StudentController@postStudent');
	Route::get('api/Students/{id}','StudentController@getById');
    Route::get('api/Students/{studentID}/delete', 'StudentController@delete');
    Route::post('api/Students/{studentID}/update', 'StudentController@update');

});	

Route::get('/api/Standards/all',function(){
	$standards = Standard::with(['streams','subjects'])->get();

	return $standards;
});

Route::get('/api/Standards/{id}',function($id){
	$standard = Standard::with(['streams','subjects'])->find($id);
	return $standard;
});
Route::post('/api/Standards/{id}/edit', function($id){
	$standard = Standard::find($id);

	if($standard)
	{
		$data = array(
			'division' => Input::get('division')
		);

		if($standard->update($data))
		{
			return Response::json(['msg' => 'Successfully Edited Standard.'],200);
		}
	}
});
Route::post('/api/Standards/add', function(){
	$standard = new Standard;
	$standard->division = Input::get('division');
	$standard->save();

	if(!is_null($streams = Input::get('streams')))
	{
		foreach($streams as $stream)
		{
			$s = new Stream;
			$s->stream = $stream['stream'];
			$s->standard_id = $standard->id;
			$s->save();
		}
	}
	return Response::json(['msg'=>'Successfully Added Standard To The System!'],200);
	
});

Route::post('/api/Standards/delete', function(){

	$standard = Standard::find(Input::get('id'));
	if($standard->hasStreams())
	{
		foreach($standard->streams as $stream)
		{
			$stream->delete();
		}
	}

	if($standard->hasSubjects())
	{
		foreach($standard->subjects as $subject)
		{
			$subject->delete();
		}
	}

	$standard->delete();

	return Response::json(['msg'=>'Successfully Deleted Standard From The System.'],200);

});

Route::post('/api/Standards/{id}/Streams/add', function($id){

	if($std = Standard::find($id))
	{
		foreach(Input::get() as $stream)
		{
			$s = new Stream;
			$s->stream = $stream['stream'];
			$s->standard_id = $std->id;
			$s->save();
		}
		return Response::json(['msg' => 'Successfully Added Stream(s) to this standard'],200);


	}

	return Response::json(['msg'=>'The Standard does not exist. Unable to add the stream.'],500);

});

Route::post('/api/Streams/{id}/edit', function($id){
	$stream = Stream::find($id);
	if($stream)
	{
		$data = array(
			'stream' => Input::get('stream')
		);

		if($stream->update($data))
		{
			return Response::json(['msg' => 'Successfully Edited Stream.'],200);
		}
	}
});

Route::post('/api/Streams/delete', function(){
	$stream = Stream::find(Input::get('id'));
	if($stream)
	{
		$stream->delete();

		return Response::json(['msg' => 'Successfully Deleted Stream From The System.'],200);
	}

});

Route::post('/api/Standards/{stdID}/Streams/{streamID}/Subjects/add', function($stdID, $streamID){

	if($std = Standard::find($stdID) && $stream = Stream::find($streamID))
	{

		$subject = new Subject;
		$subject->name = Input::get('name');
		$subject->standard_id = $stdID;
		$subject->stream_id = $streamID;
		if(!is_null(Input::get('fees')))
		{
			$subject->fees = Input::get('fees');
		}
		$subject->save();
		return Response::json(['msg'=>'Done!'],200);

	}
	else
	{
		return Response::json(['msg'=>'Something went wrong on the server side!'],500);
	}

});

Route::post('/api/Standards/{stdID}/Subjects/add', function($stdID){

	if($std = Standard::find($stdID))
	{
		$subject = new Subject;
		$subject->name = Input::get('name');
		$subject->standard_id = $stdID;
		$subject->fees = Input::get('fees');
		$subject->save();
		return Response::json(['msg'=>'Done!'], 200);
	}
	else
	{
		return Response::json(['msg'=>'Something went wrong on the server side!'], 500);
	}

});

Route::post('/api/Subjects/delete', function(){
	$subjectID = Input::get('id');
	if($subject = Subject::find($subjectID))
	{

		$subject->delete();
		return Response::json(['msg' => 'Successfully Deleted The Subject.'],200);

	}
	else
	{
		return Response::json(['msg' => 'Can not delete subject from the system at this time. Please Try Again Later.'],500);
	}
});

Route::get('api/Subjects/all', function(){
    return Subject::with('standard','stream')->get();
});

Route::post('/api/Subjects/{id}/edit', function($id){
	$subject = Subject::find($id);
	if($subject)
	{
		$subject->name = Input::get('name');
        $subject->stream_id = Input::get('stream_id');
		$subject->fees = Input::get('fees');
		$subject->save();
		
		return Response::json(['msg' => 'Successfully Edited Subject.'],200);
		
	}
});

Route::get('/api/Streams/{streamID}/Subjects/all', function($streamID){

	if($stream = Stream :: find($streamID))
	{
		return $stream->subjects;
	}


});

Route::get('/api/Standards/{stdID}/Subjects/all', function($stdID){

	if($standard = Standard :: find($stdID))
	{
		return $standard->subjects;
	}


});


Route::get('/api/schools/search/{searchTerm}',function($searchTerm){
	$schools = School::where('name','LIKE','%'.$searchTerm.'%')->get();

	return $schools;
});

Route::get('/api/mediums', function(){
	$mediums = Medium::all();

	return $mediums;
});

Route::post('api/members/add', 'StaffController@add');

Route::get('/ex',function(){

$user = User::find(1);
   return Crypt::decrypt('eyJpdiI6IjJ2NHp0RWp0dlNESCtkcmw3Y1lhNFE9PSIsInZhbHVlIjoiVmNGVWJuMFF4dDVwdTlhRmkwRkc1QT09IiwibWFjIjoiM2E1ZmNmNDIxNWQ2ZTYxYzNmNTg2ZjI2ZjYyYjY3ZDY2ODc0MzJhMzAxN2U2ZTY2NzczZWM4NTk4NDgzZTViYSJ9');
});