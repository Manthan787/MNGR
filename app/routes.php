<?php


// Landing Page
Route::get('/', 'Landing\Controller\Page@index');
Route::get('/about', 'Landing\Controller\Page@about');
Route::get('/contact', 'Landing\Controller\Page@contact');
Route::post('/contact', 'Landing\Controller\Page@postContact');


// ACHARYA ADMIN PANEL
Route::group(['before' => 'hasAccessToAdminPanel'], function(){
    Route::get('/admin', function()
    {
        $user = Auth::user();
        return View::make('Admin.index')->with('user',$user);
    });

    Route::post('api/auth/changePassword', 'Admin\AuthController@changePassword');
    Route::get('api/auth/logout','Admin\AuthController@logout');
});


Route::get('/admin/login', 'Admin\AuthController@getLogin');

Route::post("/upload", function(){
    $file = Input::file('upload');
    if($file)
    {
        $filename = $file->getClientOriginalName();
        $destination = public_path().'/Uploads';
        $status = $file->move($destination, $filename);
        if($status)
        {
            return "http://ameecomputer.in/Uploads/".$filename;
        }

    }

});

Route::get('/stats', 'Admin\DashboardController@getStats');
Route::group(['before'=>'teacher'], function() {
    Route::get('api/Chapters/all', 'Admin\ChapterController@getAll');
    Route::post('api/Chapters/add', 'Admin\ChapterController@postChapter');
    Route::get('api/Chapters/{id}/delete', 'Admin\ChapterController@getDelete');
    Route::post('api/Chapters/{id}/edit', 'Admin\ChapterController@postEdit');
    Route::get('api/Chapters/{id}/material', 'Admin\ChapterController@getMaterial');
});

Route::group(['before' => 'admin'], function() {
    // Takes User objects as recepient [array]
    Route::post('api/sms/send', 'Admin\SMSController@send');
    // Takes only one single number and a message
    Route::post('api/sms/quick-send', 'Admin\SMSController@quick');
});

Route::post('form','Admin\UserController@store');

Route::post('api/auth/login', 'Admin\AuthController@login');


Route::group(['before'=>'admin'], function() {
    Route::get('api/years/all', 'Admin\YearController@getAll');
    Route::post('api/years/add', 'Admin\YearController@postAdd');
    Route::get('api/years/{id}/delete', 'Admin\YearController@getDelete');
    Route::post('api/years/{id}/edit', 'Admin\YearController@postEdit');

});
Route::get('api/years/current','Admin\YearController@getCurrent');
#API ROUTES
Route::group(['before'=>'teacher'],function(){

	#Questions
	Route::get('api/Questions/all','Admin\QuestionController@getAll');
	Route::post('api/Questions/add','Admin\QuestionController@postQuestion');
  Route::post('api/Questions/{id}/edit', 'Admin\QuestionController@editQuestion');
	Route::get('api/Questions/{id}','Admin\QuestionController@getById');
  Route::get('api/Questions/{id}/delete','Admin\QuestionController@delete');

  #subjects
  Route::get('api/Subjects/all', 'Admin\SubjectController@all');

  #Attendance
  Route::post('api/attendances/create', 'Admin\AttendanceController@create');

  #Batches
  Route::get('api/batches/all', 'Admin\BatchController@getAll');
  Route::post('api/batches/add','Admin\BatchController@postAdd');
  Route::get('api/batches/{id}/students', 'Admin\BatchController@getStudents');

});

Route::get('/h',function(){

	$date = DateTime::createFromFormat('d/m/Y','15/09/1993')->format('Y-m-d');
	echo $date;
});

Route::group(['before'=>'teacher'],function(){

	Route::get('api/Students/all','Admin\StudentController@getAll');
	Route::post('api/Students/add','Admin\StudentController@postStudent');
	Route::get('api/Students/{id}','Admin\StudentController@getById');
  Route::get('api/Students/{studentID}/delete', 'Admin\StudentController@delete');
  Route::post('api/Students/{studentID}/update', 'Admin\StudentController@update');
  Route::get('api/Students/activated/recent', 'Admin\StudentController@recentlyActivated');

});
//TODO Create repositories for Standards and Streams and move them to seperate Controllers. Also Create form services.


Route::get('/api/Standards/all',function(){
	$standards = Standard::with(['streams','subjects','batches'])->get();
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

Route::get('api/Standards/{id}/Students', function($id) {
    if($std = Standard::find($id))
    {
      return $std->students()->with(['batches', 'stream'])->get();
    }
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

Route::get('api/Subjects/all', 'Admin\SubjectController@all');

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
Route::get('/api/Standards/{id}/batches', function($id){
    $standard = Standard::find($id);
    return $standard->batches;
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

Route::post('api/members/add', 'Admin\StaffController@add');

Route::group(['before'=>'admin'], function(){
    Route::post('api/tests/create','Admin\TestController@create');
    Route::get('api/tests/all', 'Admin\TestController@getAll');
    Route::delete('api/tests/{id}/delete', 'Admin\TestController@delete');
    Route::get('tests/{id}/show', 'Admin\TestController@show');
    Route::get('tests/{id}/answers', 'Admin\TestController@showAnswerSheet');
});

Route::post('desk/test/practice/assess', 'Desk\Controller\Test@postAssess');




//# STUDENT's APP
Route::group(['before'=>'auth.student'], function(){

    Route::get('desk/login', 'Desk\Controller\Auth@getLogin');
    Route::post('desk/login', 'Desk\Controller\Auth@postLogin');
    Route::get('desk/activate', 'Desk\Controller\Auth@getActivate');
    Route::post('desk/activate', 'Desk\Controller\Auth@postActivate');
    Route::get('desk/forgot-password', 'Desk\Controller\Auth@getForgotPassword');
    Route::post('desk/forgot-password', 'Desk\Controller\Auth@postForgotPassword');

});

Route::group(['before'=>'student'], function() {
    ## STUDENT DESK WEB APP ROUTES
    Route::get('desk/','Desk\Controller\Dashboard@getIndex');
    Route::get('desk/profile','Desk\Controller\Dashboard@getProfile');
    Route::get('desk/logout','Desk\Controller\Auth@getLogout');
    Route::get('desk/test/practice','Desk\Controller\Test@getPractice');
    Route::get('desk/study','Desk\Controller\Study@getIndex');
    Route::get('desk/change-password', 'Desk\Controller\Dashboard@getChangePassword');
    Route::post('desk/change-password', 'Desk\Controller\Dashboard@postChangePassword');

    ## STUDENT DESK API ROUTES
    Route::post('api/desk/test/practice/generate','Desk\Controller\Test@generatePractice');
    Route::get('api/desk/chapters/{id}/material', function($id){
        $chapter = Chapter::find($id);
        if($chapter)
        {
            return $chapter->material;
        }
        else
        {
            return Response::json(['msg'=>'The chapter can not be accessed at this moment. Please try again later.'],500);
        }
    });
    Route::get('api/students/me/subjects', function(){
        $subjects = Auth::user()->profile->subjects()->with('chapters')->get();
        return $subjects;
    });
});

Route::group(['before' => 'teacher'], function(){
    Route::post('api/materials/add', 'Admin\MaterialController@add');
    Route::get('api/materials/recent', 'Admin\MaterialController@getRecent');
    Route::get('api/materials/{id}', 'Admin\MaterialController@getById');
    Route::get('api/materials/{chapterID}', 'Admin\MaterialController@getByChapterId');
    Route::post('api/materials/{id}/edit', 'Admin\MaterialController@edit');
    Route::delete('api/materials/{id}/delete','Admin\MaterialController@delete');
});



Route::get('/ex', function(){

    $attendance = new Attendance;
    $attendance->date = date("yyyy-mm-dd");
    $attendance->batch_id = 1;
    $attendance->save();
    $attendance->students()->attach([10,11,12], ['present' => 1]);

});
