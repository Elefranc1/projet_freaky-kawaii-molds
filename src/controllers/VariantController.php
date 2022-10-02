<?php

$newVariantsAdded=[];
$removedVariants=[];
class VariantController
{
    

    
    function addVariants(string $label, float $price, product $product)
    {
        $variant = new Variant($product,$label,$price);
        array_push($newVariantsAdded,$variant);
    }
    
}
?>