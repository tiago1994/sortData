<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller{
    
    public function index(){
        $dados = [
            ["name"=>"Option 1","type"=>"Delivery","cost"=>10.00,"estimated_days"=>5],
            ["name"=>"Option 2","type"=>"Custom","cost"=>10.00,"estimated_days"=>3],
            ["name"=>"Option 3","type"=>"Pickup","cost"=>10.00,"estimated_days"=>3],
        ];

        $initial_cost       = 0;
        $initial_estimed    = 0;
        $error              = 0;
        $dados2             = [];

        $valores            = [];

        foreach($dados as $k => $d){
            if($k == 0){
                $valores[] = ['estimated_days' => $d['estimated_days'], 'qtd' => 1];
            }else{
                $key = array_search($d['estimated_days'], array_column($valores, 'estimated_days'));
                if($key !== false){
                    $valores[$key]['qtd'] = $valores[$key]['qtd']+1;
                }else{
                    $valores[] = ['estimated_days' => $d['estimated_days'], 'qtd' => 1];
                }
            }
        }

        dd($valores);
        dd(max(array_column($valores, 'qtd')));

        foreach($dados as $d){
            if($initial_cost == 0 || ($initial_cost == $d['cost'] && $initial_estimed == $d['estimated_days'])  ){

                $initial_cost           = $d['cost'];
                $initial_estimed        = $d['estimated_days'];
                $d['estimated_days']    = date('Y-m-d H:i:s', strtotime("+ ".$d['estimated_days']."weekdays"));
                $dados2[]               = $d;

            }else{ 
                $error = 1;
            }
        }

        if($error != 0){
            $dados2 = [];
        }

        return view('welcome')->with(compact('dados', 'dados2'));
    }

}
