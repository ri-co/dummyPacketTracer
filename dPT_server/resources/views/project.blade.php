@extends('layouts.app')

@section('project-open')
<?php

  #Check if the method is POST = Check if is it a saving
  if($_SERVER['REQUEST_METHOD'] == 'POST') {}

  #Check if in HTTP Request is specified a project to load
  elseif (isset($_GET['name'])) {

  }

  #Create a new project
  else {

    

  }

  ?>
@endsection


@section('content')
<nav class="navbar navbar-default navbar-static-bottom">
    <ul class="nav navbar-nav">
      <li> Host </li>
      <li> Hub </li>
      <li> Router </li>
      <li> Cable </li>
    </ul>
  </nav>
@endsection
