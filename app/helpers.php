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

if (!function_exists('parseConfigReceivers')) {
    /**
     * Takes a string like 'Piet Klaas<piet@mail.com>, Klaas Piet<mail@mail.com>'
     * and turns it into an array like
     * [
     *  [
     *   "name" => "Piet Klaas",
     *   "email" => "piet@mail.com",
     *  ],
     *  [
     *   "name" => "Klaas Piet",
     *   "email" => "mail@mail.com",
     *  ],
     * ]
     *
     * @param string $configLine - String in the format: 'Piet Klaas<piet@mail.com>, Klaas Piet<mail@mail.com>'.
     * @return array
     */
    function parseConfigReceivers(string $configLine): array
    {
        return array_map(fn($receiver) => [
            'name' => trim(explode('<', $receiver)[0]),
            'email' => trim(str_replace('>', '', explode('<', $receiver)[1])),
        ], explode(',', $configLine));
    }
}
