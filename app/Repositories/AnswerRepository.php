<?php
namespace App\Repositories;

use App\Model\Answer;

/**
 * Class AnswerRepository
 * @package App\Repositories
 */
class AnswerRepository extends BaseRepository
{

    /**
     * @param array $attributes
     * @return \App\Model\Answer
     */
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function byId($id)
    {
        return Answer::find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAnswerCommentsById($id)
    {
        $answer = Answer::with('comments', 'comments.user')->where('id', $id)->first();

        return $answer->comments;
    }
}