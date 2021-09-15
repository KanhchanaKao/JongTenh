<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
        DB::table('supplier')->insert(
            [
                [ 'name' =>'Khmer Beverage',
                  'image'=>'asset/supplier/1.png'
                ],
                [ 'name' =>'Unilever',
                  'image'=>'asset/supplier/2.jpg'
                ],
                [ 'name' =>'Coca Cola',
                  'image'=>'asset/supplier/3.jpg'
                ],
                [ 'name' =>'Pepsi',
                  'image'=>'asset/supplier/4.jpeg'
                ],
                [ 'name' =>'Unilever',
                  'image'=>'asset/supplier/5.jpg'
                ],
    
            ]);
       
        // // =========================================================>> Add Product
            DB::table('categories')->insert(
            [
                [ 'name' =>'Phone',
                  'image'=>'asset/category/phone.png'
                ],
                [ 'name' =>'Sports Wear',
                  'image'=>'asset/category/sportsWear.png'
                ],
                [ 'name' =>'Headsets',
                  'image'=>'asset/category/headsets.png'
                ],
                [ 'name' =>'T Shirt',
                  'image'=>'asset/category/tShirt.png'
                ],
                [ 'name' =>'Watches',
                  'image'=>'asset/category/watches.png'
                ],
                [ 'name' =>'Sports Shoes',
                  'image'=>'asset/category/sportsShoes.png'
                ],
                ['name' =>'Water',
                'image'=>'asset/category/water.png'
                ],
                ['name' =>'Acoholic Beverages',
                'image'=>'asset/category/AcholicBeverages.png'
                ],
                ['name' =>'Beverages',
                'image'=>'asset/category/beverages.png'
                ],
                ['name' =>'Milk',
                'image'=>'asset/category/milk.png'
                ],
                ['name' =>'Noodle',
                'image'=>'asset/category/noodle.png'
                ],
                ['name' =>'Snack',
                'image'=>'asset/category/snack.png'
                ],
                ['name' =>'Sweet',
                'image'=>'asset/category/sweet.png'
                ],
                ['name' =>'Yogurt',
                'image'=>'asset/category/yogurt.png'
                ],
            
            ]);

            
    
            DB::table('product')->insert(
                [
                    // ['name'=>'Jean',
                    //  'image'=>'asset/brand/brand1.jpg',
                    // ],
                    
                    // ['name'=>'T-Shirt',
                    //  'image'=>'asset/brand/brand2.png',
                    // ],
    
                    // ['name'=>'Shirt',
                    //  'image'=>'asset/brand/brand3.jpg',
                    // ],
    
                    // ['name'=>'Short',
                    //  'image'=>'asset/brand/brand4.jpg',
                    // ],
    
                    // ['name'=>' Hoodie',
                    //  'image'=>'asset/brand/brand5.png',
                    // ],
    
                    // ['name'=>'Jordan 1',
                    //  'image'=>'asset/brand/brand6.jpg',
                    // ],
    
                    // ['name'=>'Airforce1',
                    //  'image'=>'asset/brand/brand7.jpg',brand
                    // ],
    
                    // ['name'=>'Underwear',
                    //  'image'=>'asset/brand/brand8.jpg',
                 
                //=========================> Phone   
                    ['name'=>'Oppo',
                     'image'=>'asset/product/phone/phone.jpg',
                    ],
                    
                    ['name'=>'Oppo S7',
                     'image'=>'asset/product/phone/phone1.jpg',
                    ],
    
                    ['name'=>'Samsung S20',
                     'image'=>'asset/product/phone/phone2.jpg',
                    ],
    
                    ['name'=>'Hawai 20 Pro',
                     'image'=>'asset/product/phone/phone3.jpeg',
                    ],

                //=========================> Sports Wear 
                    ['name'=>' adidas ',
                     'image'=>'asset/product/sportsWear/sportsWear.jpg',
                    ],
    
                    ['name'=>'Gym Burberry ',
                     'image'=>'asset/product/sportsWear/sportsWear1.jpg',
                    ],
    
                    ['name'=>'Sports Nice ',
                     'image'=>'asset/product/sportsWear/sportsWear2.jpg',
                    ],
    
                    ['name'=>'Sports Das ',
                     'image'=>'asset/product/sportsWear/sportsWear4.jpg',
                    ],  

                //=========================> Headsets 
                ['name'=>' Sony V1',
                  'image'=>'asset/product/headsets/headsets.jpg',
                ],

                ['name'=>'King Game',
                  'image'=>'asset/product/headsets/headsets1.jpg',
                ],

                ['name'=>'Solo',
                  'image'=>'asset/product/headsets/headsets2.jpg',
                ],

                ['name'=>'Gaming',
                  'image'=>'asset/product/headsets/headsets3.jpg',
                ],  

                  //=========================> T-Shirt 
                ['name'=>'Burberry LONDON ENGLANG',
                  'image'=>'asset/product/tShirt/tShirt.jpg',
                ],

                ['name'=>'Burberry Skolo',
                  'image'=>'asset/product/tShirt/tShirt1.jpg',
                ],

                ['name'=>'Burberry black hand',
                  'image'=>'asset/product/tShirt/tShirt2.jpg',
                ],  
                ['name'=>' Burberry Burberry',
                'image'=>'asset/product/tShirt/tShirt3.jpg',
                ],

                  //=========================> Watches 
                ['name'=>'HUBLOT',
                  'image'=>'asset/product/watches/watches.jpg',
                ],

                ['name'=>'LIGE Legend',
                  'image'=>'asset/product/watches/watches1.jpg',
                ],

                ['name'=>'Vincero',
                  'image'=>'asset/product/watches/watches2.jpg',
                ],  
                ['name'=>'Roamer',
                'image'=>'asset/product/watches/watches3.jpg',
                ],

                  //=========================> Sports Shoes 
                  ['name'=>'Nike',
                  'image'=>'asset/product/sportsShoes/sportsShoes.jpg',
                ],

                ['name'=>'Sports Go',
                  'image'=>'asset/product/sportsShoes/sportsShoes1.jpg',
                ],

                ['name'=>'Vi Sports',
                  'image'=>'asset/product/sportsShoes/sportsShoes2.jpg',
                ],

                ['name'=>'adidas',
                  'image'=>'asset/product/sportsShoes/sportsShoes3.jpg',
                ],  

                  //=========================> Water 
                  ['name'=>'Sport Water',
                  'image'=>'asset/product/water/water.jpg',
                ],

                ['name'=>'Kulan',
                  'image'=>'asset/product/water/water1.jpg',
                ],

                ['name'=>'Gmy Water',
                  'image'=>'asset/product/water/water2.jpg',
                ],

                ['name'=>'Infit Button',
                  'image'=>'asset/product/water/water3.jpg',
                ],  

                  //=========================> Acoholic Beverages 
                  ['name'=>'Groden Beer',
                  'image'=>'asset/product/acoholicBeverages/acoholicBeverages.jpg',
                ],

                ['name'=>'Poroni Beer',
                  'image'=>'asset/product/acoholicBeverages/acoholicBeverage1.jpg',
                ],

                ['name'=>'Voka',
                  'image'=>'asset/product/acoholicBeverages/acoholicBeverages2.jpg',
                ],

                ['name'=>'Pro Voka',
                  'image'=>'asset/product/acoholicBeverages/acoholicBeverages3.jpg',
                ],  

                  //=========================> Beverages 
                  ['name'=>'Tea Honey',
                  'image'=>'asset/product/beverages/beverages.jpg',
                ],

                ['name'=>'Son Chaser',
                  'image'=>'asset/product/beverages/beverages1.jpg',
                ],

                ['name'=>'Tea Bi',
                  'image'=>'asset/product/beverages/beverages2.jpg',
                ], 

                ['name'=>'Pepsi',
                  'image'=>'asset/product/beverages/beverages3.jpg',
                ],
                  //=========================> Milk 
                  ['name'=>'Milk Hous',
                  'image'=>'asset/product/milk/milk.jpg',
                ],

                ['name'=>'Milk Stony',
                  'image'=>'asset/product/milk/milk1.jpg',
                ],

                ['name'=>'Milk Cow',
                  'image'=>'asset/product/milk/milk2.jpg',
                ],

                ['name'=>'Milk Button',
                  'image'=>'asset/product/milk/milk3.jpg',
                ],  

                  //=========================> Noodle 
                  ['name'=>'Hot Chiken',
                  'image'=>'asset/product/noodle/noodle.jpg',
                ],

                ['name'=>'Hot Chiken Flavor',
                  'image'=>'asset/product/noodle/noodle1.jpg',
                ],

                ['name'=>'Noodle',
                  'image'=>'asset/product/noodle/noodle2.jpg',
                ],

                ['name'=>'Curry',
                  'image'=>'asset/product/noodle/noodle3.jpg',
                ],  

                  //=========================> Snack 
                  ['name'=>'Dumle',
                  'image'=>'asset/product/snack/snack.jpg',
                ],

                ['name'=>'Candy PoP',
                  'image'=>'asset/product/snack/snack1.jpg',
                ],

                ['name'=>'Corn Nuts',
                  'image'=>'asset/product/snack/snack2.jpg',
                ],

                ['name'=>'Chex Mix',
                  'image'=>'asset/product/snack/snack3.jpg',
                ],  

                  //=========================> Sweet 
                  ['name'=>'Black Chocolate',
                  'image'=>'asset/product/sweet/sweet.jpg',
                ],

                ['name'=>'Sweet Rich',
                  'image'=>'asset/product/sweet/sweet1.jpg',
                ],

                ['name'=>'Startbus',
                  'image'=>'asset/product/sweet/sweet2.jpg',
                ],

                ['name'=>'Pi sweet',
                  'image'=>'asset/product/sweet/sweet3.jpg',
                ],  

                  //=========================> Yogurt 
                  ['name'=>'Ice Cream hard',
                  'image'=>'asset/product/yogurt/yogurt.jpg',
                ],

                ['name'=>'Stoberry',
                  'image'=>'asset/product/yogurt/yogurt1.jpg',
                ],

                ['name'=>'Total Ice',
                  'image'=>'asset/product/yogurt/yogurt2.jpg',
                ],

                ['name'=>'Greek Iec',
                  'image'=>'asset/product/yogurt/yogurt3.jpg',
                ],  
                
                ]
            );
	}
}
