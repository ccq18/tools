<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Notifications\NewMessageNotification;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;

/**
 * Class InboxController
 * @package App\Http\Controllers\Web
 */
class InboxController extends Controller
{

    /**
     * @var MessageRepository
     */
    protected $message;

    /**
     * InboxController constructor.
     */
    public function __construct(MessageRepository $message)
    {
        // $this->middleware('auth');
        $this->message = $message;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $messages = $this->message->getAllMessages();

        return view('inbox.index', ['messages' => $messages->groupBy('dialog_id')]);
    }

    /**
     * @param $dialogId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($dialogId)
    {
        $messages = $this->message->getDialogMessagesBy($dialogId);
        $messages->markAsRead();

        return view('inbox.show', compact('messages', 'dialogId'));
    }

    /**
     * @param $dialogId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($dialogId)
    {
        //todo 数据权限

        $message = $this->message->getSingleMessageBy($dialogId);
        $toUserId = $message->from_uid === user()->id ? $message->to_uid : $message->from_uid;
        $this->message->sendMessage($dialogId, user()->id, $toUserId, request('body'));

        return back();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeMessage()
    {
        $message = $this->message->sendMessage(null, user('api')->id, request('user'), request('body'));

        if ($message) {
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);
    }
}
