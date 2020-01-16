<?php

if(!function_exists('resolveProfilePic')) {
  function resolveProfilePic($user) {
    if($user->profile_picture === null) {
      $user->profile_picture = url('images/profile-placeholder.png');
    } else {
      $user->profile_picture = \Storage::url($user->profile_picture);
    }
    return $user;
  }
}

if(!function_exists('resolveProfilePics')) {
  function resolveProfilePics($users) {
    foreach($users as $user) {
      if($user->profile_picture === null) {
        $user->profile_picture = url('images/profile-placeholder.png');
      } else {
        $user->profile_picture = \Storage::url($user->profile_picture);
      }
    }
    return $users;
  }
}

if(!function_exists('centsToEuro')) {
  function centsToEuro($cents) {
    return number_format(($cents /100), 2, '.', ' ');
  }
}

if(!function_exists('orderAmt')) {
  function orderAmt() {
    $order_amt = \App\Order::where('fulfilled', '=', false)->count();
    return $order_amt;
  }
}

if(!function_exists('formatTimeForDisplay')) {
  function formatTimeForDisplay($time) {
    return $time->setTimeZone('Europe/paris')->toDateTimeString();
  }
}