<?php
$scheme=array
(
    'products' => array
    (
        'fields' => array
        (
            'products_model',
            'products_ean',
            'products_price', //Preis muss noch mit 1,19 multipliziert werden!!!
        ),
        'index' => array
        (
            'products_model'
        )
    ),


    'products_description' => array
    (
        'fields' => array
        (
            'products_name',
            'products_description',
            'products_meta_keywords'
        ),

        'index' => array
        (
            'products_id'=>array
            (
                'type'  =>'oneToOne',
                'local' =>'main_a',
                'var'   =>'products_id'
            ),
            'languages_id'=>array
            (
                'type'  =>'oneToOne',
                'local' =>'sql',
                'var'   =>'languages_id',
                'query' =>"select languages_id from languages where code='de'"
            )
        ),
    ),

    'products_images' => array
    (
        'fields' => array
        (
//            'images'=> array
//            (
//              'type'        => 'inlinetable',
//                'xmltype'     => 'children',
//                'seperator'   => '|',
//                'fields'=>array
//                (
//		      'image_nr',
//                    'url_small',
//                    'url_middle',
                    'url_big'
//                )
//            )
        ),

        'index' => array
        (
            'products_id'=>array
            (
                'type'=>'oneToMany',
                'local' =>'main_a',
                'var'=>'products_id'
            )
        ),
        'clearBeforeUpdate' => true
    ),

    'manufacturers' => array
    (
        'fields' => array
        (
            'manufacturers_name',
        ),
        'index' => array
        (
            'manufacturers_id'=>array
            (
                'type'  =>'manyToOne',
                'local' =>'main_a',
                'var'   =>'manufacturers_id'
            )
        ),
    )
 
);
?>
