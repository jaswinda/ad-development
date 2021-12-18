<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageCompressController extends Controller
{
    public function compressImage(Request $request)
    {
        $path = 'images/documents/';
        // $path = '../../../';
        if (! is_dir($path)) {
            mkdir(public_path($path), 0777, true);
        }
        $file = $request->file('image');
        $time = date("d-m-Y")."-".time() ;
        $new_image_name =  $time.'.'.$file->extension();

        $upload=$this->compress($file,$path.$new_image_name,40);

        if($upload){
            return response()->json(['success'=>true, 'message'=>'Image Has been sucessfully Uploaded', 'image'=>$new_image_name]);
        }else{
              return response()->json(['success'=>false, 'message'=>'Something went wrong, try again later']);
        }
      }

      function compress($source, $destination, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image,$destination, $quality);

        return true;
    }
}
