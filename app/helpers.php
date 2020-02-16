<?php

if (!function_exists('resolveProfilePic')) {
    function resolveProfilePic($user)
    {
        if ($user->profile_picture === null) {
            $user->profile_picture = url('images/profile-placeholder.png');
        } else {
            $user->profile_picture = \Storage::url($user->profile_picture);
        }
        return $user;
    }
}

if (!function_exists('resolveProfilePics')) {
    function resolveProfilePics($users)
    {
        foreach ($users as $user) {
            if ($user->profile_picture === null) {
                $user->profile_picture = url('images/profile-placeholder.png');
            } else {
                $user->profile_picture = \Storage::url($user->profile_picture);
            }
        }
        return $users;
    }
}

if (!function_exists('centsToEuro')) {
    function centsToEuro($cents)
    {
        return number_format(($cents / 100), 2, '.', ' ');
    }
}

if (!function_exists('orderAmt')) {
    function orderAmt()
    {
        $order_amt = \App\Order::where('fulfilled', '=', false)->count();
        return $order_amt;
    }
}

if (!function_exists('formatTimeForDisplay')) {
    function formatTimeForDisplay($time)
    {
        return $time->setTimeZone('Europe/paris')->toDateTimeString();
    }
}

if (!function_exists('formatFullDate')) {
    function formatFullDate($dateTimeObj)
    {
        return \IntlDateFormatter::formatObject(
            $dateTimeObj,
            'cccc, d MMMM yyyy',
            'nl_NL'
        );
    }
}

if (!function_exists('file_response')) {
    function file_response($path)
    {
        try {
            $path = storage_path($path);
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } catch (Exception $exception) {
            abort(404);
        }
    }
}
