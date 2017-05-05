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

                <div class="panel-body" id="main-content">
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

// sarebbe meglio $(function() { ma meno comprensibile per te
$(document).ready(function() {
    $.get('/api/projects', function (data) {
        let projects_list = '<ul>';
        for (var i=0; i<data.length; i++) {
            let project=data[i];
            projects_list += '<li>'+project.name+'</li>';
        };
        projects_list += '</ul>';
        //meglio mettere un id='main-content' oltre a class per identificarlo univocamente;
        $('#main-content').html(projects_list);
    });
});
</script>
@endsection
