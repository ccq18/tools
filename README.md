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
# 部署
生成一对私有钥放在以下目录
provisioning/templates/ssh
修改以下文件为服务器地址
provisioning/webservers
# 发布代码
ansible-playbook provisioning/prod.yml  --extra-vars "application_version=1.5"
# 更新代码
ansible-playbook provisioning/prod.yml  --extra-vars "application_version=1.5"
