<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
/**
 * @SWG\Swagger(
 *     schemes={"http","https"},
 *     host="api.host.com",
 *     basePath="/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="cabinet xiaomi ",
 *         description="cabinet xiaomi Api description...",
 *         termsOfService="",
 *         @SWG\Contact(
 *             email="ba@webinnovations.ru"
 *         ),
 *         @SWG\License(
 *             name="Private License",
 *             url="URL to the license"
 *         )
 *     ),
 *     @SWG\ExternalDocumentation(
 *         description="Find out more about my website",
 *         url="http..."
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function get_item($model,$id,$relations){
        $result  = $model::with($relations)->find($id);
        return $result;
    }
    public function item_list($model){
        $result = $model::all();
        return $result;
    }

    /**
     * @param $id
     * @param $model
     * @param array $relations
     * @return mixed
     */
    public function find($id, $model, $relations = array()){
        return $model::with($relations)->findOrNew($id);
    }


    /**
     * @param null $id
     * @param $model
     * @param $data
     * @return mixed
     */
    public function set_model($id = null, $model, $data){

//        var_dump($data->toarray());

        $obj = $this->find($id, $model);

        return $obj->updateOrCreate(['id'=>$id],$data->toarray());
    }
}
