<?php



$orders = Order::with([
    "orderState"=>function($value){
        $value->with("names");
    },
    "user"=>function($value) {
        $value->with(["company"=> function($value){
            $value->with(["priceHeader" ,"priceHeader.currency"]);
        }]);
    }
    ,
    "contract",
    "orderDetails"=>function($value){
        $value->with(["product"=>function($value){

            $value->with(["productsBrands","productCategory","productAttachment","productPriceDetails"=>function($value){
                $value->with("productPriceHeader");
            }]);

        }]);
    },
])->get();