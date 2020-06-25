<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGroupPlanFormData;
use Illuminate\Http\Request;
use App\ProductGroupPlan; // модель пользователь

use League\Csv\Reader;
use League\Csv\Statement;

use App\Shop;
use App\ProductGroupPlanType;
use App\ProductGroup;


class ProductGroupPlanController extends Controller
{

    protected $model;

    public function __construct()
    {
        $this->model = ProductGroupPlan::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productGroupPlans = ProductGroupPlan::all();
        if($productGroupPlans->count()){
            return response($productGroupPlans);
        }else{
            return response()->json(['message'=>'записей нет'], 404);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGroupPlanFormData $request)
    {
        return response($this->set_model($id = null, $model = $this->model, $request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productGroupPlan  = ProductGroupPlan::find($id);
        if($productGroupPlan){
            return response($productGroupPlan);
        }else{
            return response()->json(['message'=>'запись не найдена'], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductGroupPlanFormData $request, $id)
    {
        return response($this->set_model($id, $model = $this->model, $request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productGroupPlan  = ProductGroupPlan::find($id);
        if($productGroupPlan){
            $productGroupPlan->delete();
            return response()->json($productGroupPlan, 201);

        }else{
            return response()->json(['message'=>'не удалось удалить запись'],404);

        }
    }

    //
    public function upload(Request $request){
        $file = $request->file('file');

        if($file){

            $basenamefile = $file->getClientOriginalName();
            $extends = substr($basenamefile, strpos($basenamefile, '.', -5));

            if($extends == '.csv'){
                // сохраняем файл и записываем данные в таблицу
                $file_name = md5($basenamefile).$extends;
                $csv_file =  $file->storeAs('upload', $file_name);
                $file_path = 'storage/app/'.$csv_file;

                return $result = $this->read_csv(base_path().'/'.$file_path);
            }

        }
    }

    public function read_csv($csv_file){


        //load the CSV document from a stream
        $stream = fopen($csv_file, 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement())
            ->offset(10)
            ->limit(25);

        //query your records from the document
        $records = $stmt->process($csv);

        // массивы сущностей
        $shops = [];
        $productGroupPlanTypes = [];
        $productGroups = [];

        $productGroupPlans = [];


        foreach ($records as $record) {

            // dd($record);

            $shop_id = false;
            $product_group_id = false;
            $product_group_plan_type_id = false;


            if(isset($shops[$record['Магазин из 1С']])){
                $shop_id = $shops[$record['Магазин из 1С']];
            }
            else{

                if($shop = Shop::where('name', $record['Магазин из 1С'])->first()){
                    $shop_id = $shop->toArray()['id'];
                }else{
                   $shop_id = Shop::create([
                       'name'=>$record['Магазин из 1С']
                   ]);
                }
            }


            if(isset($productGroupPlanTypes[$record['тип плана']])){
                $product_group_plan_type_id = $productGroupPlanTypes[$record['тип плана']];

            }else{

                if($productGroupPlanType = ProductGroupPlanType::where('name', $record['тип плана'])->first()){
                    $product_group_plan_type_id = $productGroupPlanType->toArray()['id'];
                }else{
                    $product_group_plan_type_id = ProductGroupPlanType::create([
                        'name'=>$record['тип плана'],
                        'description'=>$record['тип плана']
                    ])->toArray()['id'];
                }

            }



            if(isset($productGroups[$record['Группа по планам']])){
                $product_group_id  = $productGroups[$record['Группа по планам']];
            }
            else{

                if($product_group = ProductGroup::where('name', $record['Группа по планам'])->first()){
                    $product_group_id = $product_group->toArray()['id'];
                }else{

                    $product_group_id = ProductGroup::create([
                        'name'=>$record['Группа по планам'],
                        'description'=>$record['Группа по планам']
                    ])->toArray()['id'];

                    // dd($product_group_id);
                }

                $shops[$record['Группа по планам']] = $product_group_id;

            }

            $date_from = date_format(date_create($record['дата начала действия']),"Y-m-d H:i:s");
            $date_to = date_format(date_create($record['дата окончания действия']),"Y-m-d H:i:s");


            if(!empty($shop_id) && !empty($product_group_id) && !empty($product_group_plan_type_id)){

                $obj = ProductGroupPlan::create([
                    'product_group_plan_type_id' =>$product_group_plan_type_id,
                    'product_group'=>$product_group,
                    'shop_id'=>$shop_id,
                    'date_from'=>$date_from,
                    'date_to'=>$date_to,
                    'value'=>$record['План на месяц, руб']
                ]);

                // dd($obj->toArray());
                $productGroupPlans[] = $obj->toArray();
            }

        }

        return $productGroupPlans;


    }


}
