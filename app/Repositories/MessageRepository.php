<?php

namespace App\Repositories;

use App\Model\Message;
use App\Notifications\NewMessageNotification;

/**
 * Class MessageRepository
 * @package App\Repositories
 */
class MessageRepository extends BaseRepository
{
    /**
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }

    /**
     * @return mixed
     */
    public function getAllMessages()
    {
        return Message::where('to_uid', user()->id)
                      ->orWhere('from_uid', user()->id)
                      ->with([
                          'fromUser' => function ($query) {
                              return $query->select(['id', 'name', 'avatar']);
                          },
                          'toUser'   => function ($query) {
                              return $query->select(['id', 'name', 'avatar']);
                          }
                      ])->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getDialogMessagesBy($dialogId)
    {
        return Message::where('dialog_id', $dialogId)->with([
            'fromUser' => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            },
            'toUser'   => function ($query) {
                return $query->select(['id', 'name', 'avatar']);
            }
        ])->latest()->get();
    }

    /**
     * @param $dialogId
     * @return mixed
     */
    public function getSingleMessageBy($dialogId)
    {
        return Message::where('dialog_id', $dialogId)->first();
    }

    // public function sendMessageByDialogId( $fromUserId, $toUserId, $body)
    // {
    //     $message = $this->getSingleMessageBy($dialogId);
    //     $toUserId = $message->from_uid === user()->id ? $message->to_uid : $message->from_uid;
    //     $newMessage = $this->create([
    //         'from_uid' => user()->id,
    //         'to_uid'   => $toUserId,
    //         'body'         => $body,
    //         'dialog_id'    => $dialogId
    //     ]);
    //
    //     $newMessage->toUser->notify(new NewMessageNotification($newMessage));
    // }

    public function getDiglogId($fromUserId, $toUserId)
    {
        $m = Message::whereToUserId($toUserId)
                    ->whereFromUserId($fromUserId)
                    ->first();
        if (empty($m)) {
            return $fromUserId.time();
        }

        return $m->dialog_id;

    }

    public function sendMessage($dialogId = null,$fromUserId, $toUserId, $message)
    {
        if(empty($dialogId)){
            $dialogId = $this->getDiglogId($fromUserId, $toUserId);
        }
        $newMessage = $this->create([
            'from_uid' => $fromUserId,
            'to_uid'   => $toUserId,
            'body'         => $message,
            'dialog_id'    => $dialogId
        ]);

        $newMessage->toUser->notify(new NewMessageNotification($newMessage));
        return $newMessage;
    }
}