<?php

function flashSession(){
    if (session()->has('success')){
        $message = session()->get('success');
        echo '<div data-growl="container" class="alert alert-inverse alert-dismissable growl-animated animated fadeInRight" role="alert" data-growl-position="top-center" style="position: fixed; margin: 0px 0px 0px -316.601px; z-index: 999999; display: inline-block; top: 60px; right: 10px;color:#fff"><span data-growl="icon" class="fa fa-comments"></span><span data-growl="title">'.$message.'</span></div>';
    } elseif(session()->has('error')){
        $message = session()->get('error');
        echo '<div data-growl="container" class="alert alert-inverse alert-dismissable growl-animated animated fadeInRight" role="alert" data-growl-position="top-center" style="position: fixed; margin: 0px 0px 0px -316.601px; z-index: 999999; display: inline-block; top: 60px; right: 10px;background-color: #e74c3c;color:#fff"><span data-growl="icon" class="fa fa-comments"></span><span data-growl="title">'.$message.'</span></div>';
    }
}

function frontSuccess(){
  if(session()->has('success')){
    $message = session()->get('success');
    echo '<div class="alert alert-success text-center" role="alert">'.$message.'</div>';
  }
}

function frontWarning(){
  if(session()->has('warning')){
    $message = session()->get('warning');
    echo '<div class="alert alert-warning text-center" role="alert">'.$message.'</div>';
  }
}

function frontError(){
  if(session()->has('error')){
    $message = session()->get('error');
    echo '<div class="alert alert-danger text-center" role="alert">'.$message.'</div>';
  }
}

function createSlug($str, $delimiter = '-'){
    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
    return $slug;
}

function shortContent($sentence, $count = 10) {
    $data = implode(' ', array_slice(explode(' ', $sentence), 0, $count));
    return strip_tags($data);
}

function getOrderId(){
  return 'JOJAYO-'.str_pad(time() + 1, 8, "0", STR_PAD_LEFT);
}

function getTransactionId($vendor){
  return 'NP'.$vendor.'-'.str_pad(time() + 1, 8, "0", STR_PAD_LEFT).date('Y');
}

function uploadImage($file, $dir, $thumb_dimension=null){

  $path = public_path().'/uploads/'.$dir;

  if(!File::exists($path)){
      File::makeDirectory($path, 0777, true, true);
  }
  
  $file_name = ucfirst($dir).'-'.date('Ymdhis').rand(0,999).".".$file->getClientOriginalExtension();
  $success = $file->move($path, $file_name);
  if($success){
      $file_path = $path.'/'.$file_name;
      if($thumb_dimension){
          list($width,$height) = explode('x',$thumb_dimension);
          Image::make($file_path)->resize($width,$height, function($const){
              $const->aspectRatio();
          })->save($path.'/Thumb-'.$file_name);
      }
      return $file_name;
  } else {
      return null;
  }
}

function resizeImage($path, $file_name, $file_path, $thumb_dimension){
  if($thumb_dimension){
      list($width,$height) = explode('x',$thumb_dimension);
      Image::make($file_path)->resize($width,$height, function($const){
          $const->aspectRatio();
      })->save($path.'/Thumb-'.$file_name);
  }
}

function product_img($image)
{
    return asset('uploads/products/Thumb-' . $image);
}