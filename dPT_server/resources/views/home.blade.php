@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard
                      <span> <button type="button" onclick="location.href='../projects/new'"> <img src="../new-icon.ico" class="project-button"> </button> 
                      <span>  <button type="button"> <img src="../trash-icon.ico" class="project-button"> </button>  </span>
                </div>

                <div class="panel-body">
                    You are logged in!

                    @foreach ($table as $project)

                    <li> <a href='/projects/<?php echo $project->pname ?>'> <?php echo $project->pname ?> </a> </li>

                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
