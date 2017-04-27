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
      $project = \DB::table('projects')->where('pname', '=', $name)->get();
      $project = $project->toArray();

      $devices = \DB::table('devices')->where('project', '=', $name)->get();
      $devices = $devices->toArray();

      $interfaces = array();
      $connections = array();

      #DA RIVEDERE
      /*foreach ($devices as $device) {

        $interfaces = array_push(\DB::table('interfaces')->where('device_id', '=', $device['id'])->get());
        $connections = array_push(\DB::table('connections')->where('devicea', '=', $device['id'])->orWhere('deviceb', '=', $device['id'])->get());
      }*/

      $obj_merged = array_merge($project, $devices);
      return $obj_merged;
    }




    public function newProject()
    {
        return view('project');
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
