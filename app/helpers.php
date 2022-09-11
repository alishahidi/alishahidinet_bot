<?php

use App\Models\User;

if (!function_exists('hook_download_path')) {
    function hook_download_path()
    {
        return dirname(base_path()) . '/' . 'hook' . '/' . 'download';
    }
}

if (!function_exists('hook_upload_path')) {
    function hook_upload_path()
    {
        return dirname(base_path()) . '/' . 'hook' . '/' . 'upload';
    }
}

if (!function_exists('hook_fal_path')) {
    function hook_fal_path($number)
    {
        $number = str_pad($number, 3, '0', STR_PAD_LEFT);
        $prefix = 'Hafez - ';
        $suffix = '.mp3';
        $fullName = $prefix . $number . $suffix;
        return hook_upload_path() . '/' . 'fal' . '/' . $fullName;
    }
}

if (!function_exists('hook_change_state')) {
    function hook_change_state($telegram, $state)
    {
        $message = $telegram->getMessage();
        $user_id = $message->getFrom()->getId();
        $user = User::where('user_id', $user_id)->first();
        $user->state = $state;
        $user->save();
        return true;
    }
}

if (!function_exists('hook_check_state')) {
    function hook_check_state($telegram, $state)
    {
        $message = $telegram->getMessage();
        $user_id = $message->getFrom()->getId();
        $user = User::where('user_id', $user_id)->first();
        return $user->state === $state ? true : false;
    }
}
