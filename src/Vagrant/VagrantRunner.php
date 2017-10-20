<?php

namespace Vagrant;


use App\Model\Vagrant\Vagrant;
use App\Model\Vagrant\VagrantLog;

// vagrant init        # 初始化
// vagrant up          # 启动虚拟机
// vagrant halt        # 关闭虚拟机
// vagrant reload      # 重启虚拟机
// vagrant ssh         # SSH 至虚拟机
// vagrant status      # 查看虚拟机运行状态
// vagrant destroy     # 销毁当前虚拟机
//
// vagrant suspend         # 挂起当前虚拟机
// vagrant resume          # 恢复被挂起的vm
// vagrant provision       # 设置基本的环境，进一步设置可以使用Chef/Puppet进行搭建
// vagrant ssh-config      # 输出ssh连接的一些信息
// vagrant status          # 获取虚拟机状态


// vagrant package         # 把当前的运行的虚拟机环境进行打包，可用于分发开发环境
// vagrant plugin          # 安装卸载插件

// vagrant version         # 获取vagrant的版本
//

// vagrant box list        # 列出所有box列表
//
//     vagrant box remove {base name}  # 删除
//


class VagrantRunner
{
    protected $vagrant;

    public function __construct(Vagrant $vagrant)
    {
        $this->vagrant = $vagrant;
        chdir($vagrant->path);
    }

    public function up()
    {
        return $this->exec('vagrant up');
    }

    public function halt()
    {
        return $this->exec('vagrant halt');
    }

    public function destroy()
    {
        return $this->exec('vagrant destroy -f');
    }

    public function reload()
    {
        return $this->exec('vagrant reload');

    }

    protected function exec($cmd)
    {
        // 成功：0
        //失败：1-255
        exec($cmd, $output, $status);

        return $this->addLog($output, $status);
    }


    public function addLog($output, $status)
    {
        $log = new VagrantLog();
        $log->content = implode("\n", $output);
        $log->status = $status;
        $log->vagrant_id = $this->vagrant->id;
        $log->save();

        return $log;
    }

    public function chdir($dir)
    {
        return chdir($dir);
    }
}