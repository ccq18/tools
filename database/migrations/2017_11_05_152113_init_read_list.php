<?php

use App\PersistModel\DayReadList;
use App\PersistModel\LearnInfo;
use App\PersistModel\NowReadList;
use App\PersistModel\UserConfig;

use App\PersistModel\WordCollect;
use Illuminate\Database\Migrations\Migration;

class InitReadList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ids = [10, 14, 16, 17, 18];
        foreach ($ids as $id) {
            $now = $this->getNow($id);
            $nowconfig = $this->getNow($id, 'config', []);

            //now
            $config = UserConfig::firstOrNew($id);
            if (!empty($nowconfig)) {
                if (isset($nowconfig['example'])) {
                    $config->example = $nowconfig['example'];
                }
                if (isset($nowconfig['english_trans'])) {
                    $config->english_trans = $nowconfig['english_trans'];
                }
                if (isset($nowconfig['audio_num'])) {
                    $config->audio_num = $nowconfig['audio_num'];
                }
                if (isset($nowconfig['delay_time'])) {
                    $config->delay_time = $nowconfig['delay_time'];
                }
                if (isset($nowconfig['auto_jump'])) {
                    $config->auto_jump = $nowconfig['auto_jump'];
                }
            }
            $config->now = $now;
            $config->save();
            //collect
            $collects = WordCollect::firstOrNew($id);
            $nowCollects = $this->getNow($id, 'collect', []);
            foreach ($nowCollects as $nid) {
                $collects[] = $nid;
            }
            $collects->save();
            //word-data
            $nowWordData = $this->getNow($id, 'word-data1', []);
            if (!empty($nowWordData)) {
                $learnInfo = LearnInfo::firstOrNew($id);
                $learnInfo->now = 0;
                $learnInfo->nowId = $nowWordData['now-read-id'];
                $learnInfo->nowAddedId = $nowWordData['now-read-id'];
                $learnInfo->save();
                $dayReadList = DayReadList::firstOrNew($id);
                if (!empty($nowWordData['days'])) {
                    foreach ($nowWordData['days'] as $day => $data) {
                        $dayReadList[$day] = $data['today-study-list'];
                    }
                }
                $dayReadList->save();
                $nowReadList = NowReadList::firstOrNew($id);
                $nowReadList->save();

            }

            $nowWordData = $this->getNow($id, 'wordListData2', []);
            if (!empty($nowWordData)) {
                $learnInfo = LearnInfo::firstOrNew($id);
                $learnInfo->now = 0;
                $learnInfo->nowId = $nowWordData['nowId'];
                $learnInfo->nowAddedId = $nowWordData['nowAddedId'];
                $learnInfo->save();
                $dayReadList = DayReadList::firstOrNew($id);
                if (!empty($nowWordData['days'])) {
                    $dayReadList->merge($nowWordData['days']);
                }

                $dayReadList->save();
                $nowReadList = NowReadList::firstOrNew($id);
                $nowReadList->save();

            }

        }
        //
    }

    protected function getNow($id, $prefix = '', $default = 0)
    {
        $k = 'word7000' . $prefix . $id;
        $data = \Cache::get($k, $default);

        return $data;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
