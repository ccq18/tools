<?php
namespace app\Repositories;

use App\Topic;
use Illuminate\Support\Collection;

/**
 * Class TopicRepository
 * @package app\Repositories
 *
 */
class TopicRepository
{
    /**
     * @param array $qs
     * @return  Collection
     */
    public function getTopicsForTagging($qs)
    {
        return Topic::select(['id','name'])
            ->whereIn('name',$qs)
            ->get();
    }
}