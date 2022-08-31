<?php

use App\Models\User\User;
use App\Models\Admin\Admin;

  
function active_class($path, $active = 'active') {
  return call_user_func_array('Request::is', (array)$path) ? $active : '';
}

function is_active_route($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'true' : 'false';
}

function show_class($path) {
  return call_user_func_array('Request::is', (array)$path) ? 'show' : '';
}

function introduced_by($ibm){
     $name= User::where('ibm' , '=' , $ibm)->first();
     return $name->name;
}

function getBusinessBuilderName($id){
  $businessBuilder = Admin::where('id' , '=' , $id)->first();
  return $businessBuilder->name;
}