<?php

namespace Commands;


use App\Model\Github\GithubRepository;
use App\Model\Task;

class GithubCommand extends SpiderBase
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github-spider {runner}';

    protected $baseUrl = 'https://github.com';
    protected $domain = 'github.com';


    public function runnerTask()
    {
        $http = new \Util\SpiderHttp();
        if (Task::count() == 0) {
            $starturls = ['https://github.com/search?utf8=%E2%9C%93&q=php'];
            foreach ($starturls as $v) {
                $str = $http->get($v);
                $dom = new \HtmlParser\ParserDom($str);
                $r = $dom->find('[class="filter-item"]');
                foreach ($r as $res) {
                    $this->addTask($res->getAttr('href'), 'search');
                }
            }
        }

        parent::runnerTask();
    }

    public function parse(Task $task)
    {
        if(empty($task->taskDocument)){
            return false;
        }
        $str = $task->taskDocument->page_content;
        $i = 0;
        switch ($task->type) {
            case 'search':
                $i = $this->parseSearch($str);
                break;
            case 'author_url':
                $i = $this->parseAuthor($str);
                break;
            case 'repository':
                $i = $this->parseUserrepository($str);
                break;
            case 'stars':
                $i = $this->parseUserStars($str, $task->task_url);
                break;
        }

        return $i > 0;
    }

    function parseSearch($str)
    {
        $dom = new \HtmlParser\ParserDom($str);

        $r = $dom->find("[class='repo-list-item d-flex flex-justify-start py-4 public source']");

        $next = $dom->find('[class="next_page"]');
        if (!empty($next)) {
            $this->addTask($next[0]->getAttr('href'), 'search');
        }
        $i = 0;
        foreach ($r as $res) {
            if (!empty($res->find('.v-align-middle'))) {
                $i++;
                $repository_url = !empty($res->find('.v-align-middle')) ? $this->getUrl($res->find('.v-align-middle')[0]->getAttr('href')) : "";
                $author_url = !empty($res->find('.v-align-middle')) ? $this->getUrl(dirname($res->find('.v-align-middle')[0]->getAttr('href'))) : "";
                GithubRepository::add([
                    'repository_name' => !empty($res->find('.v-align-middle')) ? trim($res->find('.v-align-middle')[0]->getPlainText()) : "",
                    'author_url'      => $this->getUrl($author_url),
                    'repository_url'  => $this->getUrl($repository_url),
                    'remark'          => !empty($res->find('[class="col-9 d-inline-block text-gray mb-2 pr-4"]')) ? trim($res->find('[class="col-9 d-inline-block text-gray mb-2 pr-4"]')[0]->getPlainText()) : "",
                    'language'        => !empty($res->find('[class="d-table-cell col-2 text-gray pt-2"]')) ? trim($res->find('[class="d-table-cell col-2 text-gray pt-2"]')[0]->getPlainText()) : "",
                    'star'            => !empty($res->find('[class="muted-link"]')) ? trim($res->find('[class="muted-link"]')[0]->getPlainText()) : 0,
                    'fork'            => 0,

                ]);

                $this->addTask($author_url, 'author_url');

            }
        }

        return $i;
    }


    function parseAuthor($str)
    {

        $dom = new \HtmlParser\ParserDom($str);
        $r = $dom->find("[class='col-12 d-block width-full py-4 border-bottom public source']");
        $next = $dom->find('[class="next_page"]');
        if (!empty($next)) {
            $this->addTask(
                $this->getUrl($next[0]->getAttr('href')), 'author_url');
        }
        $i = 0;
        if (!empty($r)) {
            foreach ($r as $res) {
                if (!empty($res->find('[itemprop="name codeRepository"]'))) {
                    $i++;
                    $repository_url = !empty($res->find('[itemprop="name codeRepository"]')) ? $this->getUrl($res->find('[itemprop="name codeRepository"]')[0]->getAttr('href')) : "";
                    $author_url = !empty($res->find('[itemprop="name codeRepository"]')) ? $this->getUrl(dirname($res->find('[itemprop="name codeRepository"]')[0]->getAttr('href'))) : "";
                    GithubRepository::add([
                        'repository_name' => !empty($res->find('[itemprop="name codeRepository"]')) ? trim($res->find('[itemprop="name codeRepository"]')[0]->getPlainText()) : "",
                        'author_url'      => $this->getUrl($author_url),
                        'repository_url'  => $this->getUrl($repository_url),
                        'remark'          => !empty($res->find('[class="col-9 d-inline-block text-gray m-0 pr-4"]')) ? trim($res->find('[class="col-9 d-inline-block text-gray m-0 pr-4"]')[0]->getPlainText()) : "",
                        'language'        => !empty($res->find('[itemprop="programmingLanguage"]')) ? trim($res->find('[itemprop="programmingLanguage"]')[0]->getPlainText()) : "",
                        'star'            => !empty($res->find('[aria-label="Stargazers"]')) ? trim($res->find('[aria-label="Stargazers"]')[0]->getPlainText()) : "",
                        'fork'            => !empty($res->find('[aria-label="Forks"]')) ? trim($res->find('[aria-label="Forks"]')[0]->getPlainText()) : "",

                    ]);
                }
            }
        } else {
            $i = -1;
            $r = $dom->find('.underline-nav-item');
            foreach ($r as $res) {
                if (strpos(trim($res->getPlainText()), 'repository') !== false) {
                    $this->addTask($res->getAttr('href'), 'repository');
                } elseif (strpos($res->getPlainText(), 'Stars') !== false) {
                    $this->addTask($res->getAttr('href'), 'stars');

                }
            }
        }


        return $i;
    }

    public function parseUserrepository($str)
    {
        $dom = new \HtmlParser\ParserDom($str);
        $r = $dom->find("[class='col-12 d-block width-full py-4 border-bottom public source']");
        $next = $dom->find('[class="next_page"]');
        if (!empty($next)) {
            $this->addTask($next[0]->getAttr('href'), 'repository');
        }
        $i = 0;
        if (!empty($r)) {
            foreach ($r as $res) {
                if (!empty($res->find('[itemprop="name codeRepository"]'))) {
                    $i++;
                    $repository_url = !empty($res->find('[itemprop="name codeRepository"]')) ? $this->getUrl($res->find('[itemprop="name codeRepository"]')[0]->getAttr('href')) : "";
                    $author_url = !empty($res->find('[itemprop="name codeRepository"]')) ? $this->getUrl(dirname($res->find('[itemprop="name codeRepository"]')[0]->getAttr('href'))) : "";
                    $data = [
                        'repository_name' => !empty($res->find('[itemprop="name codeRepository"]')) ? trim($res->find('[itemprop="name codeRepository"]')[0]->getPlainText()) : "",
                        'author_url'      => $this->getUrl($author_url),
                        'repository_url'  => $this->getUrl($repository_url),
                        'remark'          => !empty($res->find('[class="col-9 d-inline-block text-gray m-0 pr-4"]')) ? trim($res->find('[class="col-9 d-inline-block text-gray m-0 pr-4"]')[0]->getPlainText()) : "",
                        'language'        => !empty($res->find('[itemprop="programmingLanguage"]')) ? trim($res->find('[itemprop="programmingLanguage"]')[0]->getPlainText()) : "",
                        'star'            => !empty($res->find('[aria-label="Stargazers"]')) ? trim($res->find('[aria-label="Stargazers"]')[0]->getPlainText()) : "",
                        'fork'            => !empty($res->find('[aria-label="Forks"]')) ? trim($res->find('[aria-label="Forks"]')[0]->getPlainText()) : "",

                    ];
                    GithubRepository::add($data);
                }
            }
        }


        return $i;
    }

    public function parseUserStars($str, $nowurl)
    {
        $dom = new \HtmlParser\ParserDom($str);
        $r = $dom->find("[class='col-12 d-block width-full py-4 border-bottom']");
        $next = $dom->find('[class="next_page"]');
        if (!empty($next)) {
            $this->addTask($next[0]->getAttr('href'), 'stars');
        }
        $i = 0;
        if (!empty($r)) {
            foreach ($r as $res) {
                if (!empty($res->find('a'))) {
                    $i++;
                    $repository_url = !empty($res->find('a')) ? $this->getUrl($res->find('a')[0]->getAttr('href')) : "";
                    $author_url = !empty($res->find('a')) ? $this->getUrl(dirname($res->find('a')[0]->getAttr('href'))) : "";
                    if ($nowurl != $author_url) {
                        $this->addTask($next[0]->getAttr('href'), 'author_url');

                    }
                    $data = [
                        'repository_name' => !empty($res->find('a')) ? trim($res->find('a')[0]->getPlainText()) : "",
                        'author_url'      => $author_url,
                        'repository_url'  => $repository_url,
                        'remark'          => !empty($res->find('[class="d-inline-block col-9 text-gray pr-4"]')) ? trim($res->find('[class="d-inline-block col-9 text-gray pr-4"]')[0]->getPlainText()) : "",
                        'language'        => !empty($res->find('[itemprop="programmingLanguage"]')) ? trim($res->find('[itemprop="programmingLanguage"]')[0]->getPlainText()) : "",
                        'star'            => !empty($res->find('[aria-label="Stargazers"]')) ? trim($res->find('[aria-label="Stargazers"]')[0]->getPlainText()) : "",
                        'fork'            => !empty($res->find('[aria-label="Forks"]')) ? trim($res->find('[aria-label="Forks"]')[0]->getPlainText()) : "",
                    ];
                    GithubRepository::add($data);
                }
            }
        }


        return $i;
    }
}