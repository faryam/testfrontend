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
        $dir = "screenshots";
        $browsers=array();
        $test_cases=array();
        $dirs=$this->getDir($dir);
        //Get list of devices and browsers
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
        // Get list of test cases
        if (count($browsers)) {
            $selected_bro='chrome';
            $dir = "screenshots/".$browsers[0]['url'];
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
        // Defualt browser and Testcase
        $selected_test= isset($test_cases['Face'][0]) ? $test_cases['Face'][0]['url'] : '';
        $browsers=json_encode($browsers);
        $test_cases=json_encode($test_cases);

        return view('home',compact('browsers','test_cases','selected_bro','selected_test'));
    }

    //Get the  Directories in given path
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

    //Get the Images
    public function getImages(Request $request)
    {
        $dir = "screenshots";
        $images=array();
        if (isset($request->path)) {
            $dir=$dir.'/'.$request->path;
            if (file_exists($dir)) {
                $files = array_diff(scandir($dir), array('.', '..'));
                $files= $this->sortFiles($files);
                foreach ($files as $key=>$file) {
                    $image['url']=$dir.'/'.$file;
                    $file= str_replace(".png", "", $file);
                    $name_array = explode('_', $file);
                    unset($name_array[0]);
                    $image['name']= implode(" ", $name_array);
                    $images[$key]=$image;
                }
            }
        }
        $data['Images']=$images;
        return response()->json($data);
    }

    //Sort the Files according of the step
    public function sortFiles($files)
    {
        $images=[];
        foreach ($files as $file) {
            if(strpos($file, '_fail') == false)
            {
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
        }
        return $images;
    }
}
