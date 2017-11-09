# 初始化
composer install
php artisan ide-helper:meta
php artisan ide-helper:generate
php artisan ide-helper:model
npm install

vagrant  up 
vagrant  provision 
# 开发
npm run dev
npm run watch

##todo
composer 镜像
apt 镜像
pip配置
/provisioning/group_vars
/provisioning/roles/distribution/files/id_rsa
/provisioning/webservers
# 准备部署
## 设置当前主机为管理机
## 修改数据库配置
/provisioning/group_vars 文件中的default去掉并设置默认配置
## 生成一对私有钥放在以下目录
/provisioning/files/ssh
## 修改以下文件为服务器地址
/provisioning/webservers
# 部署服务器
ansible-playbook provisioning/prod.yml  --extra-vars "application_version=10.11.5"
# 发布更新代码
ansible-playbook -i provisioning/webservers provisioning/prod-distribution.yml  --extra-vars "application_version=10.19"


子模块 
git submodule add  git@gitee.com:ccq18/provisioning.git provisioning
子模块更新
git submodule foreach git pull 


npm install --save-dev babel-plugin-import
npm install --save-dev babel-preset-stage-0
npm install --save-dev babel-preset-react  
npm install --save-dev babel-preset-es2015 

npm run dev
npm run production
npm run watch
