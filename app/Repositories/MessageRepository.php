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

    // public function sendMessageByDialogId( $fromUid, $toUid, $body)
    // {
    //     $message = $this->getSingleMessageBy($dialogId);
    //     $toUid = $message->from_uid === user()->id ? $message->to_uid : $message->from_uid;
    //     $newMessage = $this->create([
    //         'from_uid' => user()->id,
    //         'to_uid'   => $toUid,
    //         'body'         => $body,
    //         'dialog_id'    => $dialogId
    //     ]);
    //
    //     $newMessage->toUser->notify(new NewMessageNotification($newMessage));
    // }

    public function getDiglogId($fromUid, $toUid)
    {
        $m = Message::whereToUid($toUid)
                    ->whereFromUid($fromUid)
                    ->first();
        if (empty($m)) {
            return $fromUid.time();
        }

        return $m->dialog_id;

    }

    public function sendMessage($dialogId = null,$fromUid, $toUid, $message)
    {
        if(empty($dialogId)){
            $dialogId = $this->getDiglogId($fromUid, $toUid);
        }
        $newMessage = $this->create([
            'from_uid' => $fromUid,
            'to_uid'   => $toUid,
            'body'         => $message,
            'dialog_id'    => $dialogId
        ]);

        $newMessage->toUser->notify(new NewMessageNotification($newMessage));
        return $newMessage;
    }
}