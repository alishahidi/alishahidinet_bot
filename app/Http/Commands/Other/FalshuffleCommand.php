<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use App\Models\Fal;
use Longman\TelegramBot\ChatAction;
use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request as RequestBot;
use Spatie\Emoji\Emoji;

class FalshuffleCommand extends UserCommand
{
    /**
     * @var string
     */
    protected $name = 'falshuffle';

    /**
     * @var string
     */
    protected $description = 'Show fal in random order';

    /**
     * @var string
     */
    protected $usage = '/falshuffle';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $chat_id    = $message->getChat()->getId();

        // Send chat action "typing..."
        RequestBot::sendChatAction([
            'chat_id' => $chat_id,
            'action'  => ChatAction::TYPING,
        ]);

        $fal = Fal::inRandomOrder()->first();
        $caption = Emoji::CHARACTER_NATIONAL_PARK . " غزل شماره : " . $fal->id . PHP_EOL . PHP_EOL .
            "------ " . Emoji::CHARACTER_SPIRAL_NOTEPAD . "شعر" . Emoji::CHARACTER_SPIRAL_NOTEPAD . " ------" . PHP_EOL . PHP_EOL .
            $fal->poem . PHP_EOL . PHP_EOL .
            "------ " . Emoji::CHARACTER_SPARKLES . "تفسیر" . Emoji::CHARACTER_SPARKLES . " ------" . PHP_EOL . PHP_EOL .
            $fal->interpretation;
        return RequestBot::sendAudio([
            'chat_id' => $chat_id,
            'caption' => $caption,
            'audio'   => RequestBot::encodeFile(hook_fal_path($fal->id)),
        ]);
    }
}
