<?php

namespace Commands;


use App\Model\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class AddRunner implements ShouldQueue
{
    use SerializesModels, Queueable;
    protected $i;

    public function __construct($i)
    {
        $this->i=$i;
    }

    public function handle()
    {

        Post::addPost(1,'title'.$this->i,'content'.$this->i);

    }
}