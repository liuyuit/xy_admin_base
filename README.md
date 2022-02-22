## License

The Project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).



## Install
> https://learnku.com/laravel/wikis/25560

为避免 docker 数据目录占用系统盘空间，需要修改 docker 数据目录至数据盘。
```
vim /etc/docker/daemon.json 
```
```
{
  "data-root": "/www/docker"
}
```
```
systemctl restart docker
```
```
cp .env.example .env
vim .env

cp docker-compose.example.yml docker-compose.yml
vim docker-compose.yml

[root@VM-8-4-centos material]# mkdir -p service/log/php
[root@VM-8-4-centos material]# mkdir -p service/log/nginx
[root@VM-8-4-centos material]# cp -R service/config.example service/config

docker-compose up -d --build
docker exec -it php_container_id /bin/bash
root@16c0c82b70e2:/var/www# chmod -R a+w storage/
root@16c0c82b70e2:/var/www# chmod -R a+w bootstrap/cache/
composer install
php artisan storage:link
php artisan key:generates
php artisan migrate --seed
chmod -R 0755 storage
sudo chown -R www-data:www-data storage
```
or
```javascript
sudo chmod -R 0777 storage
```


关闭Git检出时的换行符转换
```bash 
git config --global core.autocrlf input
```


## commands

#### docker

show ips

```
docker inspect -f '{{.Name}} - {{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' $(docker ps -aq)
```

```
 docker exec -it material_php /bin/bash
  docker exec -it material_redis /bin/bash
  docker exec -it dbde4ea9eacc  redis-cli
  
  docker-compose restart

```

#### debug

- 因为 项目使用的 docker network 别名连接的 数据库、redids。所以涉及到 数据库的 artisan 命令都需要进入容器使用

  ```
  liuyu@usercomputerdeMacBook-Air material % docker exec -it material_php /bin/bash
  root@a47deda4c162:/var/www# 
  
  root@a47deda4c162:/var/www# php artisan migrate
  Migration table created successfully.
  ```

-  MacOs中的Docker涉及到文件写入会非常慢。所以加上 cached 文件标识

  ```
  php:
        volumes:
          - ./:/var/www:cached
  ```

- 

## require
> https://github.com/w7corp/easywechat

> https://www.easywechat.com/docs/5.x/installation
> 
> https://blog.csdn.net/qq_26282869/article/details/88386836
