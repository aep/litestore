<categories>
{
    for $cat in $database/categories/category
    return <category>
           {$cat/@*}

           {
           for $cd in $database/categories_descriptions/categories_description[@categories_id=$cat/@categories_id]
           return $cd
           }
           {
           for $pi in $database/products_to_categories/products_to_category[@categories_id=$cat/@categories_id],
               $product in $database/products/product[@products_id=$pi/@products_id]
              return <product>
                {$product/@*}
                {
                        for $pd in $database/products_descriptions/products_description[@products_id=$product/@products_id]
                        return $pd
                }
                {
                        for $pi in $database/products_images/products_image[@products_id=$product/@products_id]
                        return $pi
                }


           </product>

           }


           </category>
}
</categories>

