<?php

namespace Spiders;


use App\Model\Github\GithubRepository;
use App\Model\Task;
use Exception;
use Log;

class GithubSpider
{
    static $baseUrl = 'https://github.com';
    public static function getUrl($url)
    {
        if(substr($url,0,4)=='http'){
            return $url;
        }
        return rtrim(static::$baseUrl,"/")."/".ltrim($url,"/");

    }
    static function gernerateBase($starturl)
    {
        $http = new \Util\SpiderHttp();
        $str = $http->get($starturl);
        $dom = new \HtmlParser\ParserDom($str);
        $r = $dom->find('[class="filter-item"]');
        foreach ($r as $res) {
            Task::add([
                'domain'   => 'github.com',
                'task_url' => $res->getAttr('href'),
                'type'     => 'search'
            ]);
        }
    }

    static function run()
    {
        $http = new \Util\SpiderHttp();
        while (true) {
            $task = Task::whereStatus(Task::STATUS_INIT)->first();
            if (empty($task)) {
                // sleep(10);
                echo 'END' . PHP_EOL;
                break;
            }
            $task->status = Task::STATUS_RUNNING;
            $task->save();
            echo $task->type . ' ' . $task->task_url . PHP_EOL;
            $i = 0;
            //根据页面类型解析
            try {
                $str = $http->get($task->task_url);
                if ($task->type == 'search') {
                    $i = self::parseSearch($str);
                } else if ($task->type == 'author_url') {
                    $i = self::parseAuthor($str);
                } else if ($task->type == 'repository') {
                    $i = self:: parseUserrepository($str);
                } else if ($task->type == 'stars') {
                    $i = self::parseUserStars($str, $task->task_url);
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                echo $e->getMessage() . PHP_EOL;
            }

            echo "add {$i}" . PHP_EOL;
            if ($i == 0) {
                $task->status = Task::STATUS_ERROR;
            } else {
                $task->status = Task::STATUS_SUCCESS;
            }

            $task->save();
        }

    }

    static function parseSearch($str)
    {
        $dom = new \HtmlParser\ParserDom($str);

        $r = $dom->find("[class='repo-list-item d-flex flex-justify-start py-4 public source']");

        $next = $dom->find('[class="next_page"]');
        if (!empty($next)) {
            Task::add([
                'domain'   => 'github.com',
                'task_url' => static::getUrl($next[0]->getAttr('href')),
                'type'     => 'search'
            ]);
        }
        $i = 0;
        foreach ($r as $res) {
            if (!empty($res->find('.v-align-middle'))) {
                $i++;
                $repository_url = !empty($res->find('.v-align-middle')) ? static::getUrl($res->find('.v-align-middle')[0]->getAttr('href')) : "";
                $author_url = !empty($res->find('.v-align-middle')) ? static::getUrl(dirname($res->find('.v-align-middle')[0]->getAttr('href'))) : "";
                GithubRepository::add([
                    'repository_name' => !empty($res->find('.v-align-middle')) ? trim($res->find('.v-align-middle')[0]->getPlainText()) : "",
                    'author_url'        =>  static::getUrl($author_url),
                    'repository_url'  =>  static::getUrl($repository_url),
                    'remark'            => !empty($res->find('[class="col-9 d-inline-block text-gray mb-2 pr-4"]')) ? trim($res->find('[class="col-9 d-inline-block text-gray mb-2 pr-4"]')[0]->getPlainText()) : "",
                    'language'          => !empty($res->find('[class="d-table-cell col-2 text-gray pt-2"]')) ? trim($res->find('[class="d-table-cell col-2 text-gray pt-2"]')[0]->getPlainText()) : "",
                    'star'              => !empty($res->find('[class="muted-link"]')) ? trim($res->find('[class="muted-link"]')[0]->getPlainText()) : 0,
                    'fork'              => 0,

                ]);
                Task::add([
                    'domain'   => 'github.com',
                    'task_url' => static::getUrl($author_url),
                    'type'     => 'author_url'
                ]);

            }
        }

        return $i;
    }


    static function parseAuthor($str)
    {

        $dom = new \HtmlParser\ParserDom($str);
        $r = $dom->find("[class='col-12 d-block width-full py-4 border-bottom public source']");
        $next = $dom->find('[class="next_page"]');
        if (!empty($next)) {
            Task::add([
                'domain'   => 'github.com',
                'task_url' => static::getUrl($next[0]->getAttr('href')),
                'type'     => 'author_url'
            ]);
        }
        $i = 0;
        if (!empty($r)) {
            foreach ($r as $res) {
                if (!empty($res->find('[itemprop="name codeRepository"]'))) {
                    $i++;
                    $repository_url = !empty($res->find('[itemprop="name codeRepository"]')) ? static::getUrl($res->find('[itemprop="name codeRepository"]')[0]->getAttr('href')) : "";
                    $author_url = !empty($res->find('[itemprop="name codeRepository"]')) ? static::getUrl(dirname($res->find('[itemprop="name codeRepository"]')[0]->getAttr('href'))) : "";
                    GithubRepository::add([
                        'repository_name' => !empty($res->find('[itemprop="name codeRepository"]')) ? trim($res->find('[itemprop="name codeRepository"]')[0]->getPlainText()) : "",
                        'author_url'        =>  static::getUrl($author_url),
                        'repository_url'  =>  static::getUrl($repository_url),
                        'remark'            => !empty($res->find('[class="col-9 d-inline-block text-gray m-0 pr-4"]')) ? trim($res->find('[class="col-9 d-inline-block text-gray m-0 pr-4"]')[0]->getPlainText()) : "",
                        'language'          => !empty($res->find('[itemprop="programmingLanguage"]')) ? trim($res->find('[itemprop="programmingLanguage"]')[0]->getPlainText()) : "",
                        'star'              => !empty($res->find('[aria-label="Stargazers"]')) ? trim($res->find('[aria-label="Stargazers"]')[0]->getPlainText()) : "",
                        'fork'              => !empty($res->find('[aria-label="Forks"]')) ? trim($res->find('[aria-label="Forks"]')[0]->getPlainText()) : "",

                    ]);
                }
            }
        } else {
            $i = -1;
            $r = $dom->find('.underline-nav-item');
            foreach ($r as $res) {
                if (strpos(trim($res->getPlainText()) , 'repository') !== false) {
                    Task::add([
                        'domain'   => 'github.com',
                        'task_url' => static::getUrl($res->getAttr('href')),
                        'type'     => 'repository'
                    ]);
                } elseif (strpos($res->getPlainText() , 'Stars') !== false) {
                    Task::add([
                        'domain'   => 'github.com',
                        'task_url' => static::getUrl($res->getAttr('href')),
                        'type'     => 'stars'
                    ]);
                }

            }
        }


        return $i;
    }

    public static function parseUserrepository($str)
    {
        $dom = new \HtmlParser\ParserDom($str);
        $r = $dom->find("[class='col-12 d-block width-full py-4 border-bottom public source']");
        $next = $dom->find('[class="next_page"]');
        if (!empty($next)) {
            Task::add([
                'domain'   => 'github.com',
                'task_url' => static::getUrl($next[0]->getAttr('href')),
                'type'     => 'repository'
            ]);
        }
        $i = 0;
        if (!empty($r)) {
            foreach ($r as $res) {
                if (!empty($res->find('[itemprop="name codeRepository"]'))) {
                    $i++;
                    $repository_url = !empty($res->find('[itemprop="name codeRepository"]')) ? static::getUrl($res->find('[itemprop="name codeRepository"]')[0]->getAttr('href')) : "";
                    $author_url = !empty($res->find('[itemprop="name codeRepository"]')) ? static::getUrl(dirname($res->find('[itemprop="name codeRepository"]')[0]->getAttr('href'))) : "";
                    $data = [
                        'repository_name' => !empty($res->find('[itemprop="name codeRepository"]')) ? trim($res->find('[itemprop="name codeRepository"]')[0]->getPlainText()) : "",
                        'author_url'        => static::getUrl($author_url),
                        'repository_url'  => static::getUrl($repository_url),
                        'remark'            => !empty($res->find('[class="col-9 d-inline-block text-gray m-0 pr-4"]')) ? trim($res->find('[class="col-9 d-inline-block text-gray m-0 pr-4"]')[0]->getPlainText()) : "",
                        'language'          => !empty($res->find('[itemprop="programmingLanguage"]')) ? trim($res->find('[itemprop="programmingLanguage"]')[0]->getPlainText()) : "",
                        'star'              => !empty($res->find('[aria-label="Stargazers"]')) ? trim($res->find('[aria-label="Stargazers"]')[0]->getPlainText()) : "",
                        'fork'              => !empty($res->find('[aria-label="Forks"]')) ? trim($res->find('[aria-label="Forks"]')[0]->getPlainText()) : "",

                    ];
                    GithubRepository::add($data);
                }
            }
        }


        return $i;
    }

    public static function parseUserStars($str, $nowurl)
    {
        $dom = new \HtmlParser\ParserDom($str);
        $r = $dom->find("[class='col-12 d-block width-full py-4 border-bottom']");
        $next = $dom->find('[class="next_page"]');
        if (!empty($next)) {
            Task::add([
                'domain'   => 'github.com',
                'task_url' => static::getUrl( $next[0]->getAttr('href')),
                'type'     => 'stars'
            ]);
        }
        $i = 0;
        if (!empty($r)) {
            foreach ($r as $res) {
                if (!empty($res->find('a'))) {
                    $i++;
                    $repository_url = !empty($res->find('a')) ? static::getUrl( $res->find('a')[0]->getAttr('href')): "";
                    $author_url = !empty($res->find('a')) ? static::getUrl(dirname($res->find('a')[0]->getAttr('href'))) : "";
                    if ($nowurl != $author_url) {
                        Task::add([
                            'domain'   => 'github.com',
                            'task_url' => static::getUrl( $next[0]->getAttr('href')),
                            'type'     => 'author_url'
                        ]);
                    }
                    $data = [
                        'repository_name' => !empty($res->find('a')) ? trim($res->find('a')[0]->getPlainText()) : "",
                        'author_url'        => $author_url,
                        'repository_url'  => $repository_url,
                        'remark'            => !empty($res->find('[class="d-inline-block col-9 text-gray pr-4"]')) ? trim($res->find('[class="d-inline-block col-9 text-gray pr-4"]')[0]->getPlainText()) : "",
                        'language'          => !empty($res->find('[itemprop="programmingLanguage"]')) ? trim($res->find('[itemprop="programmingLanguage"]')[0]->getPlainText()) : "",
                        'star'              => !empty($res->find('[aria-label="Stargazers"]')) ? trim($res->find('[aria-label="Stargazers"]')[0]->getPlainText()) : "",
                        'fork'              => !empty($res->find('[aria-label="Forks"]')) ? trim($res->find('[aria-label="Forks"]')[0]->getPlainText()) : "",

                    ];
                    GithubRepository::add($data);
                }
            }
        }


        return $i;
    }
}