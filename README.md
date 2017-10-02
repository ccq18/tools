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
/provisioning/group_vars
/provisioning/roles/distribution/files/id_rsa
/provisioning/webservers