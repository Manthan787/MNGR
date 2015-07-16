@extends('Desk.Dashboard.layout')

@section('title')
Online Study
@stop

@section('content')
<section ng-controller="StudyController">
    <div class="row">

        <div align="center" ng-if="loading" ng-cloak>
            <img src="{{URL::asset("app/admin/img/loader.gif")}}" height="45" width="45">
        </div>
        <div class="alert alert-error" align="center" ng-if="error" ng-cloak>
            <button type="button" class="close" data-dismiss="alert">×</button>
                @{{error}}
        </div>
        <br>
        <div class="span2" ng-if="!showTopics">
            <div class="widget">

            </div>
        </div>
        <div class="span8" ng-if="!showTopics">
            <div class="widget">
                <div class="widget-header">
                    <h3>Select Chapter</h3>
                </div>
                <div class="widget-content">
                    <form class="form-horizontal">
                        <div class="control-group" >
                            <label class="control-label">Subject</label>
                                <div class="controls">
                                    <select name="subject" ng-options="subject.id as subject.name for subject in subjects" ng-model="subject_id" ng-change="getChapters(subject_id)" >
                                        <option value="">Select Subject</option>
                                    </select>
                                </div>
                        </div>
                        <div class="control-group" ng-if="hasChapters" ng-cloak>
                            <label class="control-label">Chapter</label>
                            <div class="controls">
                                <select name="chapters" ng-options="chapter.id as chapter.title for chapter in chapters" ng-model="chapter_id" ng-change="populateTopics(chapter_id)">
                                    <option value="">Select Chapter</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group has-warning" ng-if="noChapters" ng-cloak>
                            <label class="control-label">Warning</label>
                            <div class="controls">
                                <p class="alert alert-warning">Sorry! There are no chapters in this subject at this time.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div ng-if="showTopics" ng-cloak>
        <div class="span3">
            <div class="widget widget-nopad">
                <div class="widget-header"> <i class="icon-list-alt"></i>
                    <h3>Topics</h3>
                </div>
                <div class="widget-content">
                    <ul class="news-items">
                        <li ng-repeat="topic in topics">
                            <div class="news-item-detail" class="active">
                            <a href="" ng-click="changeTopic($index)" class="news-item-title">@{{topic.topic}}</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="span9">
            <div class="widget">
                <div class="widget-header">
                   <h3>@{{topics[pointer].topic}}</h3>
                </div>
                <div class="widget-content">
                    <div ng-bind-html="topics[pointer].text"></div>
                    <div ng-bind-html="iframe"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop