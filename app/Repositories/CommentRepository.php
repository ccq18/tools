<?php
namespace App\Repositories;

use App\Model\Comment;

/**
 * Class CommentRepository
 * @package App\Repositories
 */
class CommentRepository extends BaseRepository
{
    /**
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return Comment::create($attributes);
    }
}