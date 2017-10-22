<?php

namespace Commands;

use Illuminate\Console\Command;

class GetWords  extends Command
{
    protected $signature = 'get-words';

    protected $description = 'get-words';
    public function handle()
    {
        $lineStartPattern = '/^\d+\s+[a-zA-Z\'-\/]+\s+(\[[a-zA-Z]+\]){0,1}.*\w$/s';
        $linePattern = '/.*/s';

        $logStr = file_get_contents(resource_path('/data/words.txt'));
        $n = 0;
        $diff = 0;
        $words = [];

        $this->checklogRule($logStr, $lineStartPattern, $linePattern,
            function ($match, $line) use (&$n, &$diff, &$words) {

                $lines = explode("\n", $line);
                $word = explode(" ", $lines[0]);
                // $diff1 = $word[0] - $n;
                // if ($diff1 != $diff) {
                //     $diff = $diff1;
                //     $this->assertEquals('', [$lines[0], $n, $diff]);
                // }
                $translate = str_translate(trim($word[1]));
                if(empty($translate['word_name'])){
                    return;
                }
                $this->info($lines[0]);
                $words[$n] = ['word' => trim($word[1]), 'number' => $n, 'str' => $line,'translate'=>$translate];
                $n++;
            });
        file_put_contents(config_path('/words.php'), '<?php return ' . var_export($words, true) . ';');


        // $lineSatrtPattern = '/\[\d+-\d+-\w+:\d+:\d+\+\d+:\d+]\s"\w+\s.*/s';
        // $linePattern = '/\[([^]]+)]\s+"(\w+)\s(\S+)*\s([^"]+)*"\s*(\d+)\s*(\d+)\s*"([^"]*)"\s+"([^"]*)"\s+"([^"]*)"\s+"([^"]*)"\s+"([^"]*)"\s*(\S+)\s*(\S+)\s*(\S+).*/s';
        //
        // $logStr = file_get_contents(base_path('tests/resources/nginx_access.log'));
        // $this->checklogRule($logStr, $lineSatrtPattern, $linePattern,function($match){
        //     //time http_type request_path http_version status body_bytes_sent query_string request_body http_referer http_user_agent http_x_forwarded_for remote_addr request_time upstream_response_time
        //     // $this->assertTrue(in_array($match[2], ['GET', 'HEAD','POST']), $match[2]);
        //     // $this->assertTrue(is_numeric($match[5]), $match[5]);
        //     // $this->assertTrue(is_numeric($match[13]), $match[5]);
        // });
    }



    public function checklogRule($logStr, $lineStartPattern, $linePattern, $checkLineMthod = null)
    {
        if (!is_callable($checkLineMthod)) {
            $checkLineMthod = function () {
            };
        }
        $log = $logStr;;
        $lines = explode("\n", $log);
        // dd(count($lines));
        $matchLines = collect($lines)->reduce(function ($matchLines, $line) use ($lineStartPattern) {
// dd($lineStartPattern,$line);
            try {
                if (preg_match($lineStartPattern, $line, $match)) {
                    $matchLines[] = $line;
                } else {
                    $nowline = array_pop($matchLines);
                    if (!empty($nowline)) {
                        $nowline .= "\n" . $line;
                        $matchLines[] = $nowline;
                    }
                }
            } catch (\Exception $e) {
                dd($lineStartPattern, $line, $e->getMessage());
            }

            return $matchLines;
        }, []);
        collect($matchLines)->map(function ($line) use ($linePattern, $checkLineMthod) {
            $r = preg_match($linePattern, $line, $match);
            $checkLineMthod($match, $line);
        });

    }

}