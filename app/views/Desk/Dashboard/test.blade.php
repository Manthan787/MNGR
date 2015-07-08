@extends('Desk.Dashboard.layout')

@section('title')
Practice Test
@stop

@section('content')
<div class="row" ng-controller="TestController">
    <div align="center" ng-if="loading" ng-cloak>
        <img src="{{URL::asset("app/admin/img/loader.gif")}}" height="45" width="45">
    </div>
    <div class="alert alert-error" align="center" ng-if="error" ng-cloak>
        <button type="button" class="close" data-dismiss="alert">×</button>
        @{{error}}</div>
    <br>

    <div class="span2">
        <div class="widget">

        </div>
    </div>
    <div class="span8">
        <div class="widget" ng-hide="generated">
            <div class="widget-header">
                <i class="icon-pencil"></i>
               &nbsp  Generate Practice Test
            </div>
            <div class="widget-content">
            <form class="form-horizontal" name="practiceTest" ng-submit="generate(practiceTest.$valid)" novalidate>
                <div class="control-group" >
                    <label class="control-label">Subject</label>
                    <div class="controls">
                        <select name="subject" ng-options="subject.id as subject.name for subject in subjects" ng-model="test.subject_id" ng-change="getChapters(test.subject_id)" required>
                            <option value="">Select Subject</option>
                        </select>
                        <span class="alert-error" ng-if="(submitted && practiceTest.subject.$invalid)||(practiceTest.subject.$invalid && practiceTest.subject.$dirty)" ng-cloak>
                        This field is required!
                        </span>
                    </div>
                </div>
                <div class="control-group" ng-if="hasChapters" ng-cloak>
                    <label class="control-label">Chapters</label>
                    <div class="controls">
                        <select name="chapters" ng-options="chapter.id as chapter.title for chapter in chapters" ng-model="test.chapters" ng-multiple="true" multiple required>
                        </select>
                        <br>
                        <span class="alert-error" ng-if="(submitted && practiceTest.chapters.$invalid)||(practiceTest.chapters.$invalid && practiceTest.chapters.$dirty)" ng-cloak>
                            Please select at least one chapter.
                        </span>
                    </div>
                </div>
                <div class="control-group has-warning" ng-if="noChapters" ng-cloak>
                    <label class="control-label">Warning</label>
                    <div class="controls">
                        <p class="alert alert-warning">Sorry! There are no chapters in this subject at this time.</p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Marks</label>
                    <div class="controls">
                        <select name="marks" ng-model="test.marks" required>
                            <option value="">Select Marks</option>
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="alert-error" ng-if="(submitted && practiceTest.marks.$invalid)||(practiceTest.marks.$invalid && practiceTest.marks.$dirty)" ng-cloak>
                            This field is required.
                        </span>
                    </div>
                </div>
                <div class="form-actions">
                    <input type="submit" class="btn btn-success" value="Generate Test">
                </div>
            </form>
            </div>
        </div>

        <div class="widget" id="test" ng-controller="TestpaperController" ng-show="generated" ng-cloak>
            <div class="widget-header" ng-if="!hasReport">
                &nbsp <h3>Generated Test</h3>

                <span class="pull-right" ng-if="hasBegun">@{{ pointer + 1 }}/@{{ questions.length }} &nbsp </span>
            </div>
            <div class="widget-header" ng-if="hasReport">
                &nbsp <h3>Performance Report</h3>
            </div>
            <div class="widget-content" ng-if="enableInstructions">
                    <ol>
                        <li><h4>You will be taken out of the test if you click on any other link.</h4></li>
                        <li><h4>In case you logout off the student desk while attending the test, your progress <u>will not</u> be saved.</h4></li>
                        <li><h4>You can go to the next question by clicking the next button and previous question by clicking the previous button.</h4></li>
                        <li><h4>After the completion of your test, you will have to submit your answers and you'll receive your performance report.</h4></li>
                    </ol>
                    <h3 align="center">Good Luck!</h3>
                    <button class="btn btn-success pull-right" ng-click="begin()">Begin</button>
            </div>
            <div class="widget-content" ng-if="hasBegun">

                    <h3>@{{questions[pointer].question}}</h3>
                        <div class="control-group" ng-repeat="option in questions[pointer].options">
                            <div class="pull-left">
                                <input type="radio" name="answer" value="@{{option.id}}" ng-model="questions[pointer].attempted_answer">
                            </div>
                            <h4 style="margin-left: 20px">@{{option.option}}</h4>
                        </div>
                        <br>
                    <div class="controls">
                        <button class="btn btn-primary" ng-click="previous()" ng-disabled="pointer==0">Previous</button>
                        <button class="btn btn-primary pull-right" ng-click="next()">Next</button>
                    </div>
                
            </div>
            <div class="widget-content" ng-if="hasEnded" ng-cloak>
                <h3 align="center">Congratulations!</h3>
                <h5 align="center">You've successfully completed your test.</h5>
                <h5 align="center">If you'd still like to recheck your answers, click previous. Otherwise, click submit to get performance report.</h5>
                <br>
                <button class="btn btn-primary" ng-click="previous()" ng-disabled="pointer==0">Previous</button>
                <button class="btn btn-success pull-right" ng-click="assess()">Submit</button>
            </div>
            <div class="widget-content" ng-controller="ReportController" ng-if="hasReport" ng-cloak>
                <h2 align="center">@{{ report.marks }}/@{{ report.total }}</h2>
                <div align="center" ng-if="loading" ng-cloak>
                        <img src="{{URL::asset("app/admin/img/loader.gif")}}" height="45" width="45">
                    </div>
                <div ng-if="hasIncorrectAnswers()">
                    <h2>Incorrect Answers</h2>
                    <div ng-repeat="incorrect in report.incorrect">
                        <h3>@{{ incorrect.question }}</h3>
                        <p><b>Your Answer :</b> @{{ student_answer(incorrect.options, incorrect.attempted_answer) }}</p>
                        <p><b>Correct Answer:</b> @{{ correct_answer(incorrect.options, incorrect.answer.option_id) }}</p>
                    </div>
                </div>
                <div ng-if="hasUnattemptedAnswers()">
                    <h2>Unattempted Questions</h2>
                    <div ng-repeat="unattempted in report.unattempted">
                        <h3>@{{ unattempted.question }}</h3>
                        <p><b>Correct Answer:</b> @{{ correct_answer(unattempted.options, unattempted.answer.option_id) }}</p>
                    </div>
                </div>
                <div ng-if="hasCorrectAnswers()">
                    <h2>Correct Answers</h2>
                    <div ng-repeat="correct in report.correct">
                        <h3>@{{ correct.question }}</h3>
                        <p><b>Your Answer :</b> @{{ student_answer(correct.options, correct.attempted_answer) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
