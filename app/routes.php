<?php

Route::get('/', function()
{
	$user = Auth::user();
    return View::make('Admin.index')->with('user',$user);
});

Route::get('/login', function() {
    return View::make('Admin.login');
});


Route::get('/stats', 'DashboardController@getStats');
Route::group(['before'=>'teacher'], function() {
    Route::get('api/Chapters/all', 'ChapterController@getAll');
    Route::post('api/Chapters/add', 'ChapterController@postChapter');
    Route::get('api/Chapters/{id}/delete', 'ChapterController@getDelete');
    Route::post('api/Chapters/{id}/edit', 'ChapterController@postEdit');
});

Route::post('form','UserController@store');

Route::post('api/auth/login', 'AuthController@login');
Route::get('api/auth/logout','AuthController@logout');

Route::group(['before'=>'admin'], function() {
    Route::get('api/years/all', 'YearController@getAll');
    Route::post('api/years/add', 'YearController@postAdd');
    Route::get('api/years/{id}/delete', 'YearController@getDelete');
    Route::post('api/years/{id}/edit', 'YearController@postEdit');

});
Route::get('api/years/current','YearController@getCurrent');
#API ROUTES
Route::group(['before'=>'teacher'],function(){

	#Questions
	Route::get('api/Questions/all','QuestionController@getAll');
	Route::post('api/Questions/add','QuestionController@postQuestion');
    Route::post('api/Questions/{id}/edit', 'QuestionController@editQuestion');
	Route::get('api/Questions/{id}','QuestionController@getById');
    Route::get('api/Questions/{id}/delete','QuestionController@delete');

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
//TODO Create repositories for Standards and Streams and move them to seperate Controllers. Also Create form services.
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

Route::post('/api/Standards/{stdID}/Streams/Subjects/add', function($stdID){

	if($std = Standard::find($stdID))
	{
		$subject = new Subject;
		$subject->name = Input::get('name');
		$subject->standard_id = $stdID;
		if(!is_null(Input::get('fees')))
		{
			$subject->fees = Input::get('fees');
		}
		$subject->save();
        //Attach Streams to Subject
        $streams = Input::get('streams');
        $subject->streams()->attach($streams);
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
        if(Input::get('fees')) {
            $subject->fees = Input::get('fees');
        }
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
        if($subject->streams)
        {
            $subject->streams()->detach();
        }
		$subject->delete();
		return Response::json(['msg' => 'Successfully Deleted The Subject.'],200);
	}
	else
	{
		return Response::json(['msg' => 'Can not delete subject from the system at this time. Please Try Again Later.'],500);
	}
});

Route::get('api/Subjects/all', function(){
    return Subject::with('standard','streams','chapters')->get();
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

Route::get('/api/Chapters/all', function(){
    return Chapter::all();
});

Route::get('/api/Subjects/{subjID}/Chapters', function($subID){
   return Chapter::where('subject_id', $subID)->get();
});

Route::post('/api/Chapters/add', function(){
    $chapter = new Chapter;
    $chapter->title = Input::get('title');
    $chapter->subject_id = Input::get('subject_id');
    $chapter->save();

    return Response::json(['msg'=>'Chapter Successfully Added.'],200);
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

Route::group(['before'=>'admin'], function(){
    Route::post('api/tests/create','TestController@create');
    Route::get('back/tests/{id}/show', 'TestController@show');
});

Route::post('desk/test/practice/assess', 'Desk\Controller\Test@postAssess');

Route::get('api/batches/all', 'BatchController@getAll');
Route::post('api/batches/add','BatchController@postAdd');


//# STUDENT's APP
Route::group(['before'=>'auth'], function(){

    Route::get('desk/login', 'Desk\Controller\Auth@getLogin');
    Route::post('desk/login', 'Desk\Controller\Auth@postLogin');
    Route::get('desk/activate', 'Desk\Controller\Auth@getActivate');
    Route::post('desk/activate', 'Desk\Controller\Auth@postActivate');

});

Route::group(['before'=>'student'], function() {
    Route::get('desk/','Desk\Controller\Dashboard@getIndex');
    Route::get('desk/profile','Desk\Controller\Dashboard@getProfile');
    Route::get('desk/logout','Desk\Controller\Auth@getLogout');
    Route::get('desk/test/practice','Desk\Controller\Test@getPractice');
    Route::post('api/desk/test/practice/generate','Desk\Controller\Test@generatePractice');
    Route::get('api/students/me/subjects', function(){
        $subjects = Auth::user()->profile->subjects()->with('chapters')->get();
        return $subjects;
    });
});

Route::get('/ex', function(){
    $report = new mngr\Services\Scrutineer\Report();
    $report->setTotal(10);
    $report->setMarks(5);

});