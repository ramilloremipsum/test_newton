<?php


namespace core\Services\Trees;


use core\Forms\backend\Trees\CreateAppleForm;
use core\Repositories\ApplesRepository;
use core\Repositories\TreesRepository;
use yii\helpers\Json;

class TreesService
{

    private $treesRepository;

    public function __construct(TreesRepository $treesRepository)
    {
        $this->treesRepository = $treesRepository;
    }

    public function create()
    {
        try {
            $randomName = self::getNameFromApi();
            $tree = $this->treesRepository->create($randomName);
            $this->treesRepository->save($tree);
        } catch (\Exception $e) {
            throw $e;
        }
        return $tree;
    }


    static function getNameFromApi()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://names.drycodes.com/1?nameOptions=boy_names",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw  new \Exception("cURL Error #:" . $err);
        } else {
            $data = Json::decode($response);
            return $data['0'];
        }


    }

}