## devbox
Дирректория для разворачивания локального сервера (Homestead). Работает на vagrant'е, должен быть предустановлен VirtualBox.   
Перед запуском ***vagrant up*** необходимо проверить и при необходимости заменить на свои дирректори в файле Homestead.yaml.
После первого запуска автоматически установятся зависимости, применятся миграции и засеятся тестовыми данными

## project
### что сделано?
- интегрирован инструмент SonataAdmin;
- реализован простой парсер сайта **App\Parser\PodTrade**, который запускается из консоли. Например: **php bin/console app:parse PodTrade**. 
Хотел сделать через инрерфейс админки, но при долгом парсинге падает apache и получаю 500 ошибку, Поэтому перевел на консольную команду. Ну оно понятно, такие вещи не делаются через интерфейс. )
- реализовано управление каталогом через SonataAdmin;

### что не доделал/что бы улучшил?
- не интегрировал FOSUserBundle, для авторизации и разгроничения ролей;
- в консольной команде, которую описывал ранее, не удалось автоматически использовать DI;
- для сохранения и работы с сущностями, я бы использовал DTO модели.
