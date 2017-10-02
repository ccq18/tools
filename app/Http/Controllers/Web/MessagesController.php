<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Auth;

/**
 * Class MessagesController
 * @package App\Http\Controllers\Web
 */
class MessagesController extends Controller
{
    /**
     * @var MessageRepository
     */
    protected $message;

    /**
     * MessagesController constructor.
     * @param $message
     */
    public function __construct(MessageRepository $message)
    {
        $this->message = $message;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {

        $message = $this->message->create([
            'to_uid'   => request('user'),
            'from_uid' => user('api')->id,
            'body'         => request('body'),
            'dialog_id'         => time().Auth::id(),
        ]);

        if($message) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }
}
