<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Query;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $powner = \Auth::user()->id;

        $table = \DB::table('projects')->where('powner', '=', $powner)->get();

        return view('home', compact('table'));
    }

    public function getProjects() {
      $powner = \Auth::user()->id;

      $table = \DB::table('projects')->where('powner', '=', $powner)->get();

      return $table;
    }

    public function getProject($name) {
      $rv = array();

      $rv["project"] = (array) \DB::table('projects')->where('pname', '=', $name)->get()[0];
      $rv["project"]["devices"] = [];

      $devices = \DB::table('devices')->where('project', '=', $name)->get();

      foreach ($devices as $device) {


        $device = (array) $device; //converte in array l'oggetto $device
        $device["ipaddr"] = long2ip($device["ipaddr"]);
        $device["netmask"] = long2ip($device["netmask"]);
        $device["dgateway"] = long2ip($device["dgateway"]);
        $device["interfaces"] = \DB::table('interfaces')->where('device_id', '=', $device["id"])->get();
        foreach ($device["interfaces"] as $interface) {
          $interface = (array) $interface;
          $interface["ipaddr"] = long2ip($interface["ipaddr"]);
          $interface["netmask"] = long2ip($interface["netmask"]);
        }
        array_push($rv["project"]["devices"], $device);

      }

      $rv["project"]["connections"] = \DB::table('connections')->get();

      return $rv;
    }




    public function newProject()
    {
        $powner = \Auth::user()->id;
        $pname = $_POST['pname'];
        $values = array("pname" => $pname, "powner" => $powner, "psnapshot" => "NULL");
        $project = \DB::table('projects')->insert($values);
        if($project)
          $response = array ("meta" => array(
                                              "code" => 201,
                                              "success" => true
                                            ),
                            "data" => array(
                                              "URL" => "/api/projects/".$pname

                                            ));

          return response(json_encode($response),201);
    }

    public function saveProject(Request $request, $name)
    {
        $powner = \Auth::user()->id;
        $data = $request->all() ;
        $response = array ("meta" => array(
                                            "code" => 201,
                                            "success" => true
                                          ),
                          "data" => array(
                                            "URL" => "/api/projects/".$name,
                                            "devices" => array(),
                                            "connections" => array(),
                                          ));

        if(isset($data["devices"])) {
            foreach($data["devices"] as $device) {
              $attributes = array("id" => $device['id']);
              if($device['dtype'] == 'HOST')
              $values = array("project" => $device['project'],"dtype" => $device['dtype'], "ipaddr" => ip2long($device['ipaddr']), "netmask" => ip2long($device["netmask"]), "dgateway" => ip2long($device["dgateway"]));
              else $values = array("project" => $device['project'],"dtype" => $device['dtype']);
              $result = \DB::table('devices')->updateOrInsert($attributes, $values);
              $id = \DB::select('SELECT last_insert_id() AS id;');
              $id = $id[0]->id;
              $pos = array_push($response['data']['devices'], array('id' => $id, "project" => $device['project'],"dtype" => $device['dtype'], 'interfaces' => 0));
              if($device['dtype'] == 'ROUTER') {
                  foreach($device["interfaces"] as $interface) {
                    $attributes = array("ipaddr" => $interface['ipaddr']);
                    if(!empty($interface["id"])) { $id = $interface["id"]; }
                    $values = array("ipaddr" => ip2long($interface['ipaddr']),"netmask" => ip2long($interface['netmask']), "device_id" => $id);
                    $result = \DB::table('interfaces')->updateOrInsert($attributes, $values);
                    $response['data']['devices'][$pos-1]['interfaces']+=1;
                  }

              }
        }
      }
        if(isset($data["connections"])) {
          foreach($data["connections"] as $connection) {
            $attributes = array("id" => $connection['id']);
            $values = array("devicea" => $connection['devicea'],"deviceb" => $connection['deviceb']);
            $result = \DB::table('connections')->updateOrInsert($attributes, $values);
            $id = \DB::select('SELECT last_insert_id() AS id;');
            $id = $id[0]->id;
            array_push($response['data']['connections'], array('id' => $id, 'devicea' => $connection['devicea'], 'deviceb' => $connection['deviceb']));
            }
        }
        if($result)
          return response(json_encode($response),201);
          //return response(var_dump($id),201);
    }

    public function loadProject($name)
    {
        $project = \DB::table('projects')->where('pname', '=', $name)->get();

        $devices = \DB::table('devices')->where('project', '=', $name)->get();

        $interfaces = array();
        $connections = array();

        #DA RIVEDERE
        /*foreach ($devices as $device) {

          $interfaces = array_push(\DB::table('interfaces')->where('device_id', '=', $device['id'])->get());
          $connections = array_push(\DB::table('connections')->where('devicea', '=', $device['id'])->orWhere('deviceb', '=', $device['id'])->get());
        }*/

        return view('project', compact('project', 'devices', 'interfaces', 'connections'));

    }
}
