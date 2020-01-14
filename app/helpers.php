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