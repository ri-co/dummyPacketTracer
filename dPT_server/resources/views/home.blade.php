@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard
                      <span> <button type="button" onclick="$('#new-project').show()"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                      <span>  <button type="button"> <i class="fa fa-trash" aria-hidden="true"></i> </button>  </span>
                </div>

                <div class="panel-body hidden-form" id="new-project">
              <form name="new-project" >
                  <fieldset class="form-group">
                    <label for="new-project-name">Project name</label>
                    <input type="text" class="form-control" id="new-project-name" placeholder="e.g. School network" onkeydown="if (event.keyCode == 13) { formSubmit(); return false; }">
                  </fieldset>
                  <button type="button" class="btn btn-primary" onclick="formSubmit()" > Create </button>
                </form>
                </div>

                <div class="panel-body">
                    <!--@foreach ($table as $project)

                    <li> <a href='/projects/<?php #echo $project->pname ?>'> <?php #echo $project->pname ?> </a> </li>

                    @endforeach- -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

function formSubmit() {
var pname = $('#new-project-name').val();
if(pname != "") {
    console.log("Valore ok");
    $.post('/api/projects', { pname: pname }, );
}
  else
  console.log("Valore Null");
}
</script>
@endsection
