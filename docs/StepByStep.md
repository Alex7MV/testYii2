**Пошаговое руководство по созданию приложения.**

См. официальную [документацию](https://github.com/yiisoft/yii2/tree/master/docs/guide-ru)

1. Необходимо установить (или проверить) что на компьютере установлена утилита Composer
сайт: https://getcomposer.org/.
Если её нет, то устанавливаем.
2. Будем использовать среду разработки PHPStorm, сайт: http://www.jetbrains.com/phpstorm/
3. Создаём репозиторий на github в котором будет размещен проект
4. Создаем проект в PHPStorm из репозитория размещенного в github
5. В локальном каталоге запускаем команду "composer create-project yiisoft/yii2-app-advanced advanced 2.0.13" для создания каркаса приложения, т.к. новый проект нельзя создать в не пустом каталоге, то переносим их из созданного каталога "advanced" в каталог проекта.
Ставим файлы проекта под версионный контроль из среды PHPStorm или из командной строки.
Не забываем, что папка "vendor" не ставится под версионный контроль!
6. Выполняем инициализацию окружения "Development" (для разработки) в каталоге "advanced":
~~~
# php init
Yii Application Initialization Tool v1.0

Which environment do you want the application to be initialized in?

  [0] Development
  [1] Production

  Your choice [0-1, or "q" to quit] 0

  Initialize the application under 'Development' environment? [yes|no] yes

  Start initialization ...

   generate yii
   generate yii_test
   generate yii_test.bat
   generate backend/config/main-local.php
   generate backend/config/params-local.php
   generate backend/config/test-local.php
   generate backend/web/index-test.php
   generate backend/web/index.php
   generate backend/web/robots.txt
   generate common/config/main-local.php
   generate common/config/params-local.php
   generate common/config/test-local.php
   generate console/config/main-local.php
   generate console/config/params-local.php
   generate frontend/config/main-local.php
   generate frontend/config/params-local.php
   generate frontend/config/test-local.php
   generate frontend/web/index-test.php
   generate frontend/web/index.php
   generate frontend/web/robots.txt
   generate cookie validation key in backend/config/main-local.php
   generate cookie validation key in frontend/config/main-local.php
      chmod 0777 backend/runtime
      chmod 0777 backend/web/assets
      chmod 0777 frontend/runtime
      chmod 0777 frontend/web/assets
      chmod 0755 yii
      chmod 0755 yii_test

  ... initialization completed.
~~~
7. Настраиваем бекенд:
Перехолдим в папку advanced/frontend/web и выполняем:
~~~
ln -s ../../backend/web admin
~~~
Теперь бекенд доступен по адресу /admin.

8. Настраиваем красивые адреса во фронтенде
Создаем в /frontend/web/ файл .htaccess:
~~~
Options +FollowSymLinks
IndexIgnore */*

RewriteEngine on

# if a directory or a file exists, use it directly
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# otherwise forward it to index.php
RewriteRule . index.php
~~~

В конфиге /frontend/config/main.php раскомментируем:
~~~
'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
    ],
],
~~~

9. Настраиваем красивые адреса для бекенда
Выполняем из 8. в папке backend 

