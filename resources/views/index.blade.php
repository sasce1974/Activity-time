<?php
/**
 * Created by Aleksandar Ardjanliev.

 * Date: 7/31/2019
 * Time: 1:08 PM
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Activity Time</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Spent time tracking application for various activities">
    <meta name="author" content="Aleksandar Ardjanliev">
    <meta name="keywords" content="Spent time, Time tracking, Activities time">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,500,700,900" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.css">

    <style type="text/css">
        .stripped-row:nth-of-type(odd){
            background-color: #eee;
        }
    </style>
</head>
<body>

{{--Header--}}
    <div class="bg-dark text-light px-3 py-1">
        <h3 class="font-italic"><i class="fa fa-area-chart"></i> Activity Time - Total time spent: {{(isset($activities) ? formatMinutes($activities->sum('time_spent')) : "Not loaded")}}</h3>
    </div>

{{--Messages from session--}}
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check mx-2"></i>{{Session::get('message')}}
        </div>
    @endif

{{--Input form--}}
    <div class="border-bottom p-2 px-3 bg-secondary text-light">
        <form class="row w-100" method="post" action="/store">
            @csrf
            <div class="col-md-3 form-group mb-1">
                <label for="title">Title</label>
                <input type="text" max="150" id="title" name="title" class="form-control" placeholder="Activity Title" required>
            </div>
            <div class="col-md-6 form-group mb-1">
                <label for="description">Description</label>
                <input type="text" max="2000" name="description" id="description" class="form-control" placeholder="Activity Description">
            </div>
            <div class="col-md-2 form-group mb-1">
                <label for="time_spent">Time (in minutes)</label>
                <input type="number" name="time_spent" id="time_spent" class="form-control" min="1" max="525600" required>
            </div>
            <div class="col-md-1 form-group mb-1">
                <button type="submit" class="btn btn-success mt-md-4 float-right" style="transform: translate(0, 7px)">
                    <i class="fa fa-floppy-o"></i> Save
                </button>
            </div>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

{{--Activities shown in rows--}}
    <div>
       <?php

       //function to format minutes in hours and days...

        function formatMinutes($minutes){
           $day = floor($minutes / 1440);
           $day < 1 ? $day = "" : $day = $day . "d ";
           $hours = floor(($minutes / 60) %24);
           $hours < 1 ? $hours = "" : $hours = $hours . "h ";
           $min = $minutes %60;
           return $day . $hours . $min . "m";
        }
       ?>
            <div class="d-none d-md-flex row mx-2 border text-light bg-dark font-weight-bold">
                <div class="col-3">Title</div>
                <div class="col-5">Description</div>
                <div class="col-2">Time spent</div>
                <div class="col-1">Created at</div>
                <div class="col-1">Delete</div>
            </div>
        @if(isset($activities))
            @foreach($activities as $activity)
            <div class="row stripped-row mx-2 border-bottom align-items-center" style="min-height: 50px">
                <div class="col-md-3 font-weight-bold" style="word-wrap: break-word">{{$activity->id}}. {{$activity->title}}</div>
                <div class="col-md-5" style="word-wrap: break-word">{{$activity->description}}</div>
                <div class="col-md-2 text-success font-weight-bold"><span class="d-inline d-md-none">Time spent: </span> {{formatMinutes($activity->time_spent)}}</div>
                <div class="col-11 col-md-1"><span class="d-inline d-md-none">Created at: </span> {{$activity->created_at->diffForHumans()}}</div>
                <div class="col-1">
                    <form method="post" action="/delete">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="delete_activity_id" value="{{$activity->id}}">
                        <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            </div>
            @endforeach
        <div class="w-25 my-4 text-center" style="position:absolute; left:50%; transform: translate(-50%, 0)">{{$activities->links()}}</div>
        @endif
    </div>

<script src="/js/jquery.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>