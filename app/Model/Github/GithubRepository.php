<?php

namespace App\Model\Github;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Github\GithubRepository
 *
 * @property int $id
 * @property string $repository_url
 * @property string $repository_name
 * @property string $author_url
 * @property string $language
 * @property string $remark
 * @property int $status
 * @property int $star
 * @property int $fork
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereAuthorUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereFork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereRepositoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereRepositoryUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereStar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Github\GithubRepository whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GithubRepository extends Model
{
    //
    public static function add($data)
    {
        if (GithubRepository::whereRepositoryName($data['repository_name'])->first()) {
            return false;
        }
        $repositories = new GithubRepository();
        $repositories->repository_name = $data['repository_name'];
        $repositories->author_url = $data['author_url'];
        $repositories->repository_url = $data['repository_url'];
        $repositories->language = $data['language'];

        $repositories->star = static::parseK($data['star']);


        $repositories->fork = static::parseK($data['fork']);
        $repositories->remark = $data['remark'];
        $repositories->status = 1;//1 正常
        $repositories->save();
    }

    public static function parseK($v)
    {
        $v = trim($v);

        if (strlen($v) > 1 && substr($v, -1, 1) == 'k') {
            return intval(floatval(rtrim($v, 'k')) * 1000);
        } else {
            return intval($v);
        }
    }
}
