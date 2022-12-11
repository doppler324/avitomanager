<?php

namespace App\Components\Avito;

use App\Models\AdModel;
use App\Models\ProjectModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Encryption\Encrypter;
use PhpParser\Node\Expr\Array_;


class AvitoApiComponent
{
    // Текущий проект
    protected ?ProjectModel $project;

    function __construct(ProjectModel $project)
    {
        $this->project = $project;
        try {
            self::checkAccessToken();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Получение или обновление access token
     * @return string
     */
    public function setAccessToken()
    {
        try {
            $response = Http::asForm()->post('https://api.avito.ru/token', [
                'client_id' => $this->project->client_id,
                'client_secret' => $this->project->client_secret,
                'grant_type' => 'client_credentials',
            ])->throw()->json();
            $this->project->access_token = $response['access_token'];
            $this->project->access_token_time = now();
            $this->project->save();
        } catch (Exception $ex) {
            return $ex->getCode();
        }
    }

    /**
     * Проверка устарел ли access token и получение нового в случае отсутсвия или истечения срока
     * @return bool
     */
    public function checkAccessToken(): bool
    {
        if (empty($this->project->access_token) || now()->gte($this->project->access_token_time)) {
            return self::setAccessToken() == 200;
        }
        return true;
    }

    /**
     * Возвращает список объявлений авторизованного пользователя - статус, категорию и ссылку на сайте
     * @return mixed
     */
    public function loadAds(): Array
    {
        // объявление переменных
        $result = array();
        $response = array();
        // получаем объявления с Авито
        try {
            do {
                // делаем запрос к Авито в цикле, пока не загрузим все объявления, Авито отдает максимум по 100 штук
                $response =
                    Http::withHeaders(['Authorization' => 'Bearer ' . $this->project->access_token])
                        ->get('https://api.avito.ru/core/v1/items', [
                            'per_page' => 100,
                            'page' => !empty($response['meta']['page']) ? $response['meta']['page'] + 1 : 1,
                            'status' => "active,removed,old,blocked,rejected",
                        ])
                        // если вернулась ошибка, выбрасываем ошибку
                        ->throwIf(!empty($response["code"]) || !$response)
                        ->json();

                // добавляем объявления к результату
                $result = array_merge($result, $response['resources']);

                #todo сделать возможность устанавливать задержку в обращении к Авито
                sleep(1);

            } while (!empty($response['resources']));
        } catch (Exception $ex) {
            return [
                "success" => false,
                "message" => $ex->getMessage(),
                "messageFromAvito" => $response
            ];
        }

        #todo добавить вывод в лог добавленных объявлений
        // Добавляем объявления в БД
        foreach ($result as $ad){
            if(!AdModel::where("avito_id", $ad["id"])->exists()){
                AdModel::create([
                    "avito_id" => $ad["id"],
                    "price" => $ad["price"],
                    "status" => $ad["status"],
                    "title" => $ad["title"],
                    "url" => $ad["url"],
                    "category_id" => $ad["category"]["id"],
                    "project_id" => $this->project->id
                ]);
            }
        }

        return [
            "success" => true
        ];
    }

    /**
     *  Возвращает данные об объявлении - его статус, список примененных услуг
     * @return mixed
     */
    public function loadAdInfo()
    {
        $result = array();
        try {
            foreach (AdModel::all()->chunk(1) as $item) {
                $response =
                    Http::withHeaders(['Authorization' => 'Bearer ' . $this->project->getAccessTokenAttribute()])
                        ->get('https://api.avito.ru/core/v1/accounts/' . $this->project->avito_profiles_id . '/items/' .
                            $item->id . '/')
                        ->throw()
                        ->json();
                $result[] = $response;
                sleep(1);
            }
        } catch (Exception $ex) {
            if ($ex->getCode() != 200) {
                return $ex->getMessage();
            }
        }
        return $result;
    }

    /**
     *  Получение информации о стоимости дополнительных услуг
     * @return mixed
     */
    public function loadAdsCostServices()
    {
        $result = array();
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $this->project->getAccessTokenAttribute()])
                ->post('https://api.avito.ru/core/v1/accounts/' . $this->project->avito_profiles_id . '/price/vas',
                    [
                        'itemIds' => AdModel::all()->get()->implode('id', ',')
                    ])
                ->throw()
                ->json();
            $result = $response;
        } catch (Exception $ex) {
            if ($ex->getCode() != 200) {
                return $ex->getMessage();
            }
        }
        return $result;
    }

    /**
     *  Получение статистики по списку объявлений
     * @return mixed
     */
    public function loadAdsListInfo()
    {
        $result = array();
        try {
            foreach (AdModel::all()->chunk(200) as $item) {
                $response = Http::withHeaders(['Authorization' => 'Bearer ' . $this->project->getAccessTokenAttribute(),
                    'Content-Type' => 'application/json'])
                    ->post('https://api.avito.ru/stats/v1/accounts/' . $this->project->avito_profiles_id . '/items',
                        [
                            'dateFrom' => now()->subDays(270)->format('YYYY-MM-DD'),
                            'dateTo' => now()->format('YYYY-MM-DD'),
                            'fields' => 'uniqViews,uniqContacts,uniqFavorites',
                            'itemIds' => $item->get('id')->implode('id', ','),
                            'periodGrouping' => 'day'
                        ])
                    ->throw()
                    ->json();
                $result[] = $response['result'];
                sleep(1);
            }
        } catch (Exception $ex) {
            if ($ex->getCode() != 200) {
                return $ex->getMessage();
            }
        }
        return $result;
    }

    /**
     *  Получение информации о стоимости пакетов дополнительных услуг
     * @return mixed
     */
    public function loadAdsCostPakagesServices()
    {
        $result = array();
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $this->project->getAccessTokenAttribute()])
                ->post('https://api.avito.ru/core/v1/accounts/' . $this->project->avito_profiles_id .
                    '/price/vas_packages',
                    [
                        'itemIds' => AdModel::all()->get('id')->implode('id', ',')
                    ])
                ->throw()
                ->json();
            $result = $response;
        } catch (Exception $ex) {
            if ($ex->getCode() != 200) {
                return $ex->getMessage();
            }
        }
        return $result;
    }

    /**
     *  Получение статистики по звонкам
     * @return mixed
     */
    public function loadAdsCalls()
    {
        $result = array();
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $this->project->getAccessTokenAttribute(),
                'Content-Type' => 'application/json'])
                ->post('https://api.avito.ru/core/v1/accounts/' . $this->project->avito_profiles_id . '/calls/stats/',
                    [
                        'itemIds' => AdModel::all()->get('id')->implode('id', ',')
                    ])
                ->throw()
                ->json();
            $result = $response;
        } catch (Exception $ex) {
            if ($ex->getCode() != 200) {
                return $ex->getMessage();
            }
        }
        return $result;
    }

    /**
     *  Получение баланса кошелька пользователя
     * * @param string $id
     * @return mixed
     */
    public function loadBalance($project): Array
    {
        $response = "";
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $project->access_token,
                'Content-Type' => 'application/json'])
                ->get('https://api.avito.ru/core/v1/accounts/' . $project->profile_id . '/balance/')
                ->throwIf(!empty($response["error"]))
                ->json();
            $project->fill([
                "balance" => $response["real"],
                "bonus_balance" => $response["bonus"],
            ]);
            $project->save();
        } catch (Exception $ex) {
            if ($ex->getCode() != 200) {
                return [
                    "success" => false,
                    "message" => $ex->getMessage(),
                    "messageFromAvito" => $response['error']
                ];
            }
        }
        return [
            "success" => true
        ];
    }

    /**
     *  Получение информации об авторизованном пользователе
     * @return mixed
     */
    public function loadInfoProject($project) : Array
    {
        $response = array();
        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $project->access_token,
                'Content-Type' => 'application/json'])
                ->get('https://api.avito.ru/core/v1/accounts/self/')
                ->throwIf(!empty($response["error"]))
                ->json();
            $project->fill([
                "email" => $response["email"],
                "name" => $response["name"],
                "phone" => $response["phone"],
                "profile_url" => $response["profile_url"],
                "profile_id" => $response["id"],
            ]);
            $project->save();
        }catch (Exception $ex) {
            if ($ex->getCode() != 200) {
                return [
                    "success" => false,
                    "message" => $ex->getMessage(),
                    "messageFromAvito" => $response["error"]
                ];
            }
        }
        return [
            "success" => true
        ];
    }

    /**
     *  Парсинг категорий с сайта Авито
     * @return mixed
     */
    public static function loadCategories()
{


    /*$link = "https://avito.ru";
    // получаем страницу get-запросом
    try {
      $body = Http::get($link)->throw()->body();
    }catch(Exception $ex){
      return $ex->getMessage();
    }
    // создаём краулер для получения данных
    $crawler = new Crawler(null, $link);
    $crawler->addHtmlContent($body, 'UTF-8');
    // Получение категорий
    $categories = $crawler->filter('#category option')->each(
      function ($node, $i) {
        if($node->text() == 'Любая категория'){
          return false;
        }
        $id = $node->attr('value');
        $name = $node->text();
        return array($id, $name);
      }
    );
    unset($crawler);
    return $categories;*/
}
}
