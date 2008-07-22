declare variable $stdin external;
<products>
{
    for $p in doc($stdin)/dataroot/*

    return <product>
    {
        for $i in $p/(products_model,products_ean,products_quantity,products_price,products_status,products_tax_class_id,ibc_supplies,products_vpe_value,products_vpe_status,products_fsk18,products_vpe_status,products_vpe_value,products_sort)
        return attribute{fn:node-name($i)}{fn:string($i)}
    }
        <products_description>
        {
            for $i in $p/(products_name,products_description,products_short_description,products_keywords,products_meta_title,products_meta_description,products_meta_keywords,products_trading_unit_name)
            return attribute{fn:node-name($i)}{fn:string($i)}
        }
            <language code="{fn:string($p/code)}" />
        </products_description>



        {
            for $i in $p/products_vpe_name
            return   <products_vpe products_vpe_name="{fn:string($i)}" > <language code="{fn:string($p/code)}" /> </products_vpe>
        }





        {
            for $i in $p/products_shippingtime
            return <shipping_status shipping_status_name="{fn:string($i)}"  shipping_status_id="{fn:string($p/shipping_status_id)}" >
                        <language code="{fn:string($p/code)}" /> 
                    </shipping_status>
        }


        {
            for $i in $p/manufacturers_name
            return <manufacturer manufacturers_name="{fn:string($i)}" />
        }
    </product>
}
</products>