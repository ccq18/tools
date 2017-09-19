<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Auth;

/**
 * Class AnswersController
 * @package App\Http\Controllers\Web
 */
class AnswersController extends Controller
{
    /**
     * @var AnswerRepository
     */
    protected $answer;

    /**
     * AnswersController constructor.
     * @param $answer
     */
    public function __construct(AnswerRepository $answer)
    {
        $this->answer = $answer;
    }

    /**
     * @param StoreAnswerRequest $request
     * @param $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAnswerRequest $request, $question)
    {
        $answer = $this->answer->create([
            'question_id' => $question,
            'user_id'     => Auth::id(),
            'body'        => $request->get('body')
        ]);
        $answer->question()->increment('answers_count');

        return back();
    }
}
