@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="projects-home">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" id="dashboard">Dashboard
                      <span> <button type="button" onclick="$('#new-project').show()"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                      <span>  <button type="button"> <i class="fa fa-trash" aria-hidden="true"></i> </button>  </span>
                </div>

                <div class="panel-body hidden-element" id="new-project">
              <form name="new-project" >

                  <fieldset class="form-group">
                    <label for="new-project-name">Project name</label>
                    <input type="text" class="form-control" id="new-project-name" placeholder="e.g. School network" onkeydown="if (event.keyCode == 13) { formSubmit(); return false; }">
                  </fieldset>
                  <button type="button" class="btn btn-primary" onclick="newProject()" > Create </button>
                </form>
                </div>

                <div class="panel-body" id="projects-list">

                </div>
            </div>
        </div>
    </div>

    <div class="row hidden-element" id="project-panel">
        <div class="col-md-12">
          <h1 id="pname">  </h1>






          <div class="panel panel-default">
            <div class="panel-heading">
              <button type="button" onclick="routerPanel()"><img src="https://openclipart.org/download/216575/network_router_generic.svg" class="img-circle img-device-list"></button>
              <button type="button" onclick="hubPanel()"><img src="https://openclipart.org/download/171420/switch-hub.svg" class="img-device-list"></button>
              <button type="button" onclick="hostPanel()"><img src="https://openclipart.org/download/4714/BigRedSmile-A-new-Computer.svg" class="img-device-list"></button>
            </div>
            <div class="panel-body hidden-element" id="routerPanel">
              <form name="new-router-interface" id="interface1">
                  <label class="label label-default"> Interface 1</label>
                  <fieldset class="form-group">
                    <label for="interface1-ipaddr">IP Address</label>
                    <input type="text" class="form-control" id="interface1-ipaddr" placeholder="e.g. 192.168.254.254" onkeydown="if (event.keyCode == 13) { insertRouter(); return false; }">
                  </fieldset>
                  <fieldset class="form-group">
                    <label for="interface1-netmask">Netmask</label>
                    <input type="text" class="form-control" id="interface1-netmask" placeholder="e.g. 255.255.0.0" onkeydown="if (event.keyCode == 13) { insertRouter(); return false; }">
                  </fieldset>
                  <button type="button" class="btn btn-primary" onclick="insertRouter()" > Create </button>
                  <button type="button" onclick="addInterface()"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                </form>
            </div>
            <div class="panel-body hidden-element" id="hubPanel">
                <h2> Hub </h2>
                <button type="button" class="btn btn-primary" onclick="insertHub()" > Create </button>
            </div>
            <div class="panel-body hidden-element" id="hostPanel">
              <form name="new-router-interface" id="hostForm">
                  <label class="label label-default"> New host</label>
                  <fieldset class="form-group">
                    <label for="host-ipaddr">IP Address</label>
                    <input type="text" class="form-control" id="host-ipaddr" placeholder="e.g. 192.168.254.254" onkeydown="if (event.keyCode == 13) { insertRouter(); return false; }">
                  </fieldset>
                  <fieldset class="form-group">
                    <label for="host-netmask">Netmask</label>
                    <input type="text" class="form-control" id="host-netmask" placeholder="e.g. 255.255.0.0" onkeydown="if (event.keyCode == 13) { insertRouter(); return false; }">
                  </fieldset>
                  <fieldset class="form-group">
                    <label for="host-dgateway">Default gateway</label>
                    <input type="text" class="form-control" id="host-dgateway" placeholder="e.g. 192.168.254.254" onkeydown="if (event.keyCode == 13) { insertRouter(); return false; }">
                  </fieldset>
                  <button type="button" class="btn btn-primary" onclick="insertHost()" > Create </button>
                </form>
            </div>
          </div>
        </div>
    </div>






</div>
@endsection

@section('scripts')
<script>

function newProject() {
var pname = $('#new-project-name').val();
if(pname != "") {
    console.log("Value ok");
    $.post('/api/projects', { pname: pname }, openPanel(pname));

}
  else
  console.log("Valore Null");
}

function addInterface() {

  var id = 1;
  while($("#interface"+ id).length != 0) {
    id++;
  }
  var newForm = $("#interface1").clone();
  console.log(newForm);
  newForm[0].id = "interface"+id;
  newForm[0].firstChild.textContent = "Interface "+id;
  newForm[0][1].id = "interface"+id+"-ipaddr";
  newForm[0][3].id = "interface"+id+"-netmask";
  newForm[0][4].remove();
  newForm[0][4].remove();
  newForm.appendTo("#routerPanel");
}

function openPanel(pname) {
  $('#projects-home').hide();
  console.log(pname);
  $('#pname').html(pname);
  $.get('/api/projects/'+pname, function(data) {

    /*mostra a video*/

  });

  $('#project-panel').show();
}

function routerPanel() {

  if($('#routerPanel').css('display') == 'none')
    $('#routerPanel').show();
  else
    $('#routerPanel').hide();

}

function hubPanel() {

  if($('#hubPanel').css('display') == 'none')
    $('#hubPanel').show();
  else
    $('#hubPanel').hide();

}

function hostPanel() {

  if($('#hostPanel').css('display') == 'none')
    $('#hostPanel').show();
  else
    $('#hostPanel').hide();

}

function insertHub() {
  var pname = $('#pname').text();
  var req_data ={"devices": [{ "id": "",
                                "project": pname,
                                "dtype": "HUB",
                            }]};
  $.ajax({
    url: '/api/projects/' + pname,
    type: 'PUT',
    data: req_data
  });
}

function insertHost() {

    /*prende i dati della/delle interfacce di rete -
    da fare in loop (ciclo con contatore ripetuto n volte; n = numero interfacce) */
    var pname = $('#pname').text();
    var req_data ={"devices": [{ "id": "",
                                  "project": pname,
                                  "dtype": "HOST",
                                  "ipaddr": $('#host-ipaddr').val(),
                                  "netmask": $('#host-netmask').val(),
                                  "dgateway": $('#host-dgateway').val()
                              }]};
    //richiesta PUT /api/projects/:id

    $.ajax({
      url: '/api/projects/' + pname,
      type: 'PUT',
      data: req_data
    });
}

function insertRouter() {

    /*prende i dati della/delle interfacce di rete -
    da fare in loop (ciclo con contatore ripetuto n volte; n = numero interfacce) */
    var pname = $('#pname').text();
    var req_data ={"devices": [{ "id": "",
                                  "project": pname,
                                  "dtype": "ROUTER",
                                  "interfaces": []
                              }]};
    for(var id = 1; $("#interface"+ id).length != 0; id++) {
      console.log("entro")
        var ip_address = $('#interface'+id+'-ipaddr').val();
        var netmask = $('#interface'+id+'-netmask').val();
        req_data.devices[0].interfaces.push({"id": "", "ipaddr" : ip_address , "netmask" : netmask});
    }
    //richiesta PUT /api/projects/:id

    $.ajax({
      url: '/api/projects/' + pname,
      type: 'PUT',
      data: req_data
    });
}

function csrfSafeMethod(method) {
  // these HTTP methods do not require CSRF protection
  return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
}

// sarebbe meglio $(function() { ma meno comprensibile per te
$(document).ready(function() {
    $.get('/api/projects', function (data) {
        let projects_list = '<ul>';
        for (var i=0; i<data.length; i++) {
            let project=data[i];
            parameter = '`'+project.pname+'`';
            function_call = '"openPanel(' + parameter + ')"';
            projects_list += '<li> <a onclick='+function_call+'>'+project.pname+'</a> </li>';
        };
        projects_list += '</ul>';
        //meglio mettere un id='projects-list' oltre a class per identificarlo univocamente;
        $('#projects-list').html(projects_list);
    });

    $.ajaxSetup({
      beforeSend: function(xhr, settings) {
        if (!csrfSafeMethod(settings.type) && !this.crossDomain) {
          xhr.setRequestHeader("X-CSRF-Token", window.Laravel.csrfToken);
        }
      }
    });
});
</script>
@endsection
