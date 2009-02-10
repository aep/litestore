<?php
$scheme=array
(
    'customers' => array
    (
        'fields'=>array
        (
            'customers_cid',
            'customers_vat_id',
            'customers_status',
            'customers_gender',
            'customers_firstname',
            'customers_lastname',
            'customers_email_address',
            'customers_telephone',
            'customers_fax'
        ),
        'index' => array
        (
            'customers_cid'
        )
    ),
    'address_book' => array
    (
        'fields'=>array
        (
            'entry_gender',
            'entry_company',
            'entry_street_address',
            'entry_postcode',
            'entry_city'
        ),
        'index' => array
        (
            'customers_id' => array
            (
                'type'  =>'oneToOne',
                'local' =>'main_a',
                'var'   =>'customers_id'
            )
        )
    )
);
?>
