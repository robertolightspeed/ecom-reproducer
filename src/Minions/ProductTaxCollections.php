<?php
namespace App\Minions;

use App\Reproducer;

class ProductTaxCollections extends Reproducer
{
    private static $taxCollectionId;

    public function _prepare()
    {
        $taxCollectionTitle = 'Tax Collection '.mt_rand().mt_rand();

        self::$taxCollectionId = $this->post('collections.json', [
            'collection' => [
                'title'       => $taxCollectionTitle,
            ],
        ])->getJson()['collection']['id'];

        echo "Tax Collection Created \n";
    }

    public function _action()
    {
        $productValue = 'Product '.mt_rand().mt_rand();
        $productId = $this->post('products.json', [
            'product' => [
                'en' => [
                    'title'       => $productValue,
                    'fulltitle'   => $productValue,
                    'description' => $productValue,
                    'content'     => $productValue,
                ],
            ],
        ])->getJson()['product']['id'];

        $this->post('collections/' . self::$taxCollectionId . '/products.json', [
            'collection_product' => [
                'product_id'  => $productId,
            ],
        ]);


        echo "Tax Class -> product related \n";
    }
}