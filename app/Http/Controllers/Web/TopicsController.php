<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\TopicRepository;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    protected $topic;

    /**
     * TopicsController constructor.
     * @param $topic
     */
    public function __construct(TopicRepository $topic)
    {
        $this->topic = $topic;
    }

    public function index(Request $request)
    {
        $qs = explode(' ',$request->query('q'));

        $topics= $this->topic->getTopicsForTagging($qs);
        return collect($qs)->filter(function($v)use ($topics){
            return $topics->where('name','=',$v)->isEmpty();
        })->map(function($v){
            return ['name'=>$v,'id'=>0];
        })->merge($topics);


    }
}
