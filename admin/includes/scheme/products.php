<?php
$scheme=array
(
    'products' => array
    (
        'fields' => array
        (
            'products_model',
//             'products_ean',
//             'products_quantity',
//             'products_shippingtime',
//             'products_sort',
//             'products_price',
//             'products_discount_allowed',
//             'products_weight',
//             'products_fsk18',
//             'products_vpe',
//             'products_vpe_status',
//             'products_vpe_value',
//             'products_trading_unit',
            'ibc_supplies'
        ),
        'index' => array
        (
            'products_model'
        )
    ),
//    'categories_description' => array
//     (
//         'fields' => array
//         (
//             'categories' => array 
//             (
//                 'fields'=>array('categories_name'),
//                 'type'  =>'tree',
//                 'seperator'   =>'|',
//                 'table' =>'categories',
//                 'id'    =>'categories_id',
//                 'parent'=>'parent_id'
//             )
//         ),
// 
//         'index' => array
//         (
//             'categories_id'=>array
//             (
//                 'type'  =>'manyToMany',
//                 'table' =>'products_to_categories',
//                 'index'   => array 
//                 (
//                     'products_id' => array
//                     (
//                         'type'  =>'oneToOne',
//                         'local' =>'main_a',
//                         'var'   =>'products_id'
//                     )
//                 )
// 
//             ),
//             'language_id'=>array
//             (
//                 'type'  =>'oneToOne',
//                 'local' =>'sql',
//                 'var'   =>'languages_id',
//                 'query' =>"select languages_id from languages where code='de'"
//             )
//         )
//     ),

    'products_description' => array
    (
        'fields' => array
        (
            'products_name',
            'products_description',
//             'products_short_description',
//             'products_keywords',
//             'products_meta_title',
//             'products_meta_description',
//             'products_meta_keywords'
        ),

        'index' => array
        (
            'products_id'=>array
            (
                'type'  =>'oneToOne',
                'local' =>'main_a',
                'var'   =>'products_id'
            ),
            'language_id'=>array
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
            'images'=> array
            (
                'type'        =>'inlinetable',
                'seperator'   =>'|',
                'fields'=>array
                (
                    'url_small',
                    'url_middle',
                    'url_big'
                )
            )
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
