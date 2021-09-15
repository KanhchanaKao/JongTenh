<?php

use Illuminate\Database\Seeder;
use App\Model\Product\Product; 

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
        //Seed Rate

        DB::table('rate')->insert(
            [
                [ 'name' => 'Very Poor',    'color' => 'black'],
                [ 'name' => 'Poor',         'color' => 'orange'],
                [ 'name' => 'Fair',         'color' => 'grey'], 
                [ 'name' => 'Good',         'color' => 'blue'], 
                [ 'name' => 'Excellent',    'color' => 'green'], 

            ]);

        $data = [];
        $totalProduct = DB::table('product')->count();

        for($i = 1; $i <= $totalProduct; $i++){

            $totalReview = rand(10, 20); 
            $product = Product::find($i);
            $score = 0; 

            for($j = 1; $j <= $totalReview; $j++){
                $customer = DB::table('customer')->find(rand(1, 19));

                //Check if this customer use to buy this product
                $rate = rand(1, 5); 
                $score += $rate; 
                $data[] = [
                    'rate_id'       => $rate, 
                    'customer_id'   => $customer->id, 
                    'product_id'    => $product->id, 
                    'comment'       => 'N/A', 
                    'created_at'    => Date('Y-m-d H:i:s')

                ]; 
            }

            $product->rate_score = $score/$totalReview; 
            $product->review_rate_id = round($score/$totalReview); 
            $product->save(); 
           
        }

        DB::table('review')->insert($data);

        
    }

}
