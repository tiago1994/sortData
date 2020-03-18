<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AfterTestController extends Controller{
    
    public function index(){
        $dados = [
            ["name"=>"Option 1","type"=>"Delivery","cost"=>10.00,"estimated_days"=>4],
            ["name"=>"Option 2","type"=>"Custom","cost"=>10.00,"estimated_days"=>5],
            ["name"=>"Option 3","type"=>"Pickup","cost"=>10.00,"estimated_days"=>4],
        ];

        $dados2 = $dados;
        $newArray = [];
        $firstValue = 0;
        $error = 1;

        usort($dados2, function($a, $b) {
            return $a['estimated_days'] <=> $b['estimated_days'];
        });

        
        foreach($dados2 as $k => $d){
            if($k == 0){
                $firstValue = $d['estimated_days'];
                $newArray[] = $d;
            }else{
                if($firstValue == $d['estimated_days']){
                    $newArray[] = $d;
                }else{
                    $error = 0;
                }
            }
        }

        if($error == 1){
            $error = 0;
            $newArray = [];

            usort($dados2, function($a, $b) {
                return $a['cost'] <=> $b['cost'];
            });
    
            
            foreach($dados2 as $k => $d){
                if($k == 0){
                    $firstValue = $d['cost'];
                    $newArray[] = $d;
                }else{
                    if($firstValue == $d['cost']){
                        $newArray[] = $d;
                    }else{
                        $error = 0;
                    }
                }
            }

            if($error == 1){
                $newArray = [];
            }
        }


        foreach($newArray as $k => $n){
            $newArray[$k]['estimated_days']    = date('Y-m-d H:i:s', strtotime("+ ".$n['estimated_days']."weekdays"));
        }

        $dados2 = $newArray;

        return view('welcome')->with(compact('dados', 'dados2'));
    }

}
