<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\File;
use Storage;
use Auth;
use App\User;
use App\Activity;
use Intervention\Image\ImageManagerStatic as Image;
use App\Equipment;
use App\Equip_rent;
use App\Equip_rent_record;

use App\Siteinfo;
use Mail;

class ApiController extends Controller
{
    //activity
    public function getActivityById($id){
        return Activity::find($id);
    }

    public function getAllRegistedEvent(){
        
        if ( Auth::check() ){
            $user = Auth::user();
            $registRecord= $user->registRecords()->where("cancel",false)->get();
            return $registRecord;
        }else{
            return [];
        }
    }

    public function getEventRegisterList($activityId){
        
        if ( Auth::check() ){
            $user = Auth::user();
            if ($user->admingroup=="root"){
                $activity = Activity::find($activityId);
                return $activity->registList;
            }
        }
    }

    public function getUserList(){
        if ( Auth::check() ){
            $user = Auth::user();
            if ($user->admingroup=="root"){
                return User::all();
            }
        }
    }


    public function upload_image(){
        $input = Input::all();
        if(Input::file())
         {
  
  
           $image = Input::file('file');
           // $ext = $image->getClientOriginalExtension();
           $filename  =  date('Y_m_d_h_i_s').'_'. $_FILES['file']['name'] ;
  
           // prevent possible upsizing
           // dd("storage/".$filename);
           $img = Image::make($image);
           $img->resize(1920, null, function ($constraint) {
               $constraint->aspectRatio();
               $constraint->upsize();
           });
  
           $path = 'img/uploaded/';
           
           $img->save(storage_path('app/'.$path.$filename));
           // dd($img->__toString());
          
           Storage::put($path.$filename,$img->__toString());
  
  
           return '/storage/'.$path.str_replace(" ","%20",$filename);
       
               // Image::make($image->getRealPath())->resize(200, 200)->save($path);
               // $user->image = $filename;
               // $user->save();
        }
    }
    
    //取得使用者租借清單
    public function getEquipmentList(){
        if ( Auth::check() ){
            $user = Auth::user();
            $equip_record= 
                $user->equipRents()
                     ->where("cancel",false)
                    ->with("equip_rent_record")->get();
            // return $equip_record;
            foreach ($equip_record as $eqrecord){
                foreach ($eqrecord["equip_rent_record"] as $equip_rr){
                    $equip_rr["equipment"]=Equipment::find($equip_rr["id"]);
                }
            }
            return $equip_record;
        }else{
            return [];
        }

    }

    //取得使用者租借清單
    public function getEquipmentListAll(){
        if ( Auth::check() ){
            $user = Auth::user();
            // dd($user);
            if ($user->admingroup=="root"){
                $equip_record= 
                    Equip_rent::where("cancel",false)
                        ->with("equip_rent_record")->with('user')->get();
                // return $equip_record;
                foreach ($equip_record as $eqrecord){
                    foreach ($eqrecord["equip_rent_record"] as $equip_rr){
                        $equip_rr["equipment"]=Equipment::find($equip_rr["id"]);
                    }
                }
            }
            return $equip_record;
        }else{
            return [];
        }

    }


    //許願b
    public function makeWish(){
        $mail_title = '台大創新設計學院課程許願';
        if ( Auth::check() ){
            $user = Auth::user();
            // Mail::send('emails.activity.confirm.'.$action , $data , function($message) use ($activity,$user,$mail_title ){
            //     $message
            //         ->from('ntudschool@ntu.edu.tw','Dschool台大創新設計學院')
            //         // ->bcc('frank890417@gmail.com', '吳哲宇')
            //         ->to($user->email,$user->name)->subject($mail_title);
            // });
            // dd($user);
            // if ($user->admingroup=="root"){
            // $equip_record= 
            //     Equip_rent::where("cancel",false)
            //         ->with("equip_rent_record")->with('user')->get();
            // // return $equip_record;
            // foreach ($equip_record as $eqrecord){
            //     foreach ($eqrecord["equip_rent_record"] as $equip_rr){
            //         $equip_rr["equipment"]=Equipment::find($equip_rr["id"]);
            //     }
            // }
            // }
            // return $equip_record;
        }else{
            return [];
        }

    }

    public function siteInfo($title){
        return Siteinfo::where("title",$title)->first();
    }
}
