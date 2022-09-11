<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Exception\TelegramLogException;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;

class HookController extends Controller
{
    public function set($token)
    {
        if ($token !== env('HOOK_TOKEN'))
            abort(401, 'Unauthorized');
        try {
            $telegram = new Telegram(env("HOOK_API_TOKEN"), env("HOOK_USERNAME"));
            $result = $telegram->setWebhook(env("HOOK_URL"));
            echo $result->getDescription();
        } catch (TelegramException $e) {
            echo $e->getMessage();
        }
    }

    public function unset($token)
    {
        if ($token !== env('HOOK_TOKEN'))
            abort(401, 'Unauthorized');
        try {
            $telegram = new Telegram(env("HOOK_API_TOKEN"), env("HOOK_USERNAME"));
            $result = $telegram->deleteWebhook();
            echo $result->getDescription();
        } catch (TelegramException $e) {
            echo $e->getMessage();
        }
    }

    public function update($token)
    {
        if ($token !== env('HOOK_TOKEN'))
            abort(401, 'Unauthorized');

        try {
            $telegram = new Telegram(env("HOOK_API_TOKEN"), env("HOOK_USERNAME"));
            $telegram->addCommandsPaths(Config::get('hook.commands.paths'));
            $telegram->enableMySql(Config::get('hook.mysql'), 'core_');
            $telegram->setDownloadPath(hook_download_path());
            $telegram->setUploadPath(hook_upload_path());
            // $telegram->enableLimiter(Config::get('hook.limiter'));
            $telegram->handle();
        } catch (TelegramException $e) {
            // Log telegram errors
            TelegramLog::error($e);

            // Uncomment this to output any errors (ONLY FOR DEVELOPMENT!)
            file_put_contents('test', $e);
            echo $e;
        } catch (TelegramLogException $e) {
            // Uncomment this to output log initialisation errors (ONLY FOR DEVELOPMENT!)
            file_put_contents('test1', $e);
            echo $e;
        }
    }
}
