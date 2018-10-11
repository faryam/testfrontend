<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $dir = "test_dir";
        $browsers=array();
        $test_cases=array();
        $dirs=$this->getDir($dir);
        foreach ($dirs as $value) {
            if ($value=='mobile') {
                $moDir=$this->getDir($dir.'/mobile');
                foreach ($moDir as $mvalue) {
                     array_push($browsers,['text'=>$mvalue,'url'=>'mobile/'.$mvalue]);
                }
            }
            else
            {
                array_push($browsers,['text'=>$value,'url'=>$value]);
            }
        }
        $selected_bro='';

        if (count($browsers)) {
            $selected_bro='chrome';
            $dir = "test_dir/".$browsers[0]['url'];
            $dirs=$this->getDir($dir);
            foreach ($dirs as $value) {
                $test_cases[$value]=array();
                $inDir=$this->getDir($dir.'/'.$value);
                if (count($inDir)) {
                    foreach ($inDir as $mvalue) {
                        array_push($test_cases[$value],['text'=>$mvalue,'url'=>$value.'/'.$mvalue]);
                    }
                }
                else
                {
                    array_push($test_cases[$value],['text'=>$value,'url'=>$value]);
                }
            }
        }
        $selected_test= isset($test_cases['face'][0]) ? $test_cases['face'][0]['url'] : '';
        $browsers=json_encode($browsers);
        $test_cases=json_encode($test_cases);
        
        return view('home',compact('browsers','test_cases','selected_bro','selected_test'));
    }


    public function getDir($dir)
    {
        $values = scandir($dir);
        $dirs=array();
        foreach ($values as $value) {
            $check_file=explode('.',$value);
            if (count($check_file)==1) {
                array_push($dirs, $value);
            }
        }
        return $dirs;
    }

    public function getImages(Request $request)
    {
        $dir = "test_dir";
        $images=array();
        if (isset($request->path)) {
            $dir=$dir.'/'.$request->path;
            if (file_exists($dir)) {
                $files = array_diff(scandir($dir), array('.', '..'));
                $files= $this->sortFiles($files);
                foreach ($files as $key=>$file) {
                    $image['url']=$dir.'/'.$file;
                    $image['name']=$file;
                    $images[$key]=$image;
                }
            }
        }
        $data['Images']=$images;
        return response()->json($data);
    }

    public function sortFiles($files)
    {
        $images=[];
        foreach ($files as $file) {
            $name_array= explode('_',$file);
            if (isset($name_array[0]) && is_numeric($name_array[0])) {
                $index=$name_array[0];
                $images[$index]=$file;
            }
            else if(strpos($file, '.png')||strpos($file, '.PNG')||strpos($file, '.jpg')||strpos($file, '.JPG'))
            {
                array_push($images,$file);
            }
        }
        return $images;
    }
}
