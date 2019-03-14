<?php

namespace App\Http\Controllers;

use App\Program;
use App\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{

    public function watchHooks(Request $request)
    {
        return view('hooks');
    }

    public function pingHooks()
    {
        $programs = Program::where('id', '>', 0)->get();
        return json_encode($programs);
    }

    public function makeHook()
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://maker.ifttt.com/trigger/test/with/key/cRnxXVrMCnN5AVQZJtClND");
        curl_setopt($ch, CURLOPT_POST, 1);
       

        // In real life you should use something like:
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
                 http_build_query(array('lol' => 'test')));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        curl_close ($ch);

        // Further processing ...
        if ($server_output == "OK") { 
            echo "ok";
            exit;
          }
    }

    public function storeHook(Request $request)
    {
        $program = Program::create([
          'name' => $request->data ?? 'Empty',
          'user_id' => 919,
          'description' => $request->all()['time'],
          'image_url' => 'custom',
        ]);

        $this->makeHook();
        

        return $program->id;
    }

}
