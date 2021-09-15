<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
	{
	    DB::table('users_type')->insert(
            [
                [ 'name' =>'Admin'],
                [ 'name' => 'Customer'],

            ]);

        // =========================================================>> Add Admin
        DB::table('user')->insert(
            [
                [ 
                    'type_id'=>1, 
                    'email'=>'phireak@gmail.com', 
                    'phone' => '085481821', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>2, 
                    'is_email_verified'=>1, 
                    'name' => 'Noun Phireak', 
                    'avatar'=>'public/user/profile.png'
                ], 
                
                [ 
                    'type_id'=>2, 
                    'email'=>'kimhak@gmail.com', 
                    'phone' => '081707922', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Han Kimhak', 
                    'avatar'=>'public/user/profile.png'
                ], 

                [ 
                    'type_id'=>2, 
                    'email'=>'ngoun@gmail.com', 
                    'phone' => '0962219253', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Touch Heangngoun', 
                    'avatar'=>'public/user/profile.png'
                ], 

                [ 
                    'type_id'=>2, 
                    'email'=>'sokha@gmail.com', 
                    'phone' => '099266987', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Kheng Sokha', 
                    'avatar'=>'public/user/profile.png'
                ], 

                [ 
                    'type_id'=>2, 
                    'email'=>'yunsotherith@gmail.com', 
                    'phone' => '0960000111', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Yun Sothearith', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'theara@gmail.com', 
                    'phone' => '0960000222', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Thea Ra', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'mouycheak@mgmail.com', 
                    'phone' => '0960000333', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Mouy Cheak', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'heanghong@gmail.com', 
                    'phone' => '0960000444', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Heang Hong', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'hongty@gmail.com', 
                    'phone' => '0960000555', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Hong Ty', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'sokheang@gmail.com', 
                    'phone' => '0960000666', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Sok Heang', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'thonghor@gmail.com', 
                    'phone' => '0960000777', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Thong Hor', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'chikay@gmail.com', 
                    'phone' => '0960000888', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Chi Kay', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'bora@gmail.com', 
                    'phone' => '096000099', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Bo Ra', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'vichboth@gmail.com', 
                    'phone' => '0960001111', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Vich Both', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'dararith@gmail.com', 
                    'phone' => '0960002222', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Dara Riht', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'meandararith@gmail.com', 
                    'phone' => '0960003333', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Mean Dararith', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'cymeng@gmail.com', 
                    'phone' => '0960004444', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Cy Meng', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'meas@gmail.com', 
                    'phone' => '0960005555', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Meas', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'hokty@gmail.com', 
                    'phone' => '0960006666', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Hok Ty', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'boramey@gmail.com', 
                    'phone' => '0960007777', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Bo Ramey', 
                    'avatar'=>'public/user/profile.png'
                ], 
                [ 
                    'type_id'=>2, 
                    'email'=>'meakra@gmail.com', 
                    'phone' => '096000888', 
                    'password' => bcrypt('123456'), 
                    'is_active'=>1, 
                    'is_email_verified'=>1, 
                    'name' => 'Meak Ra', 
                    'avatar'=>'public/user/profile.png'
                ], 

            ]);

            DB::table('customer')->insert(
            [
                [ 
                    'user_id'   =>2, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>3, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>4, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>5, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>6, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>7, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>8, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>9, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>10, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>11, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>12, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>13, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>14, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>15, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>16, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>17, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>18, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>19, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>20, 
                    'address'   =>'Phnom Penh'
                ], 
                [ 
                    'user_id'   =>21, 
                    'address'   =>'Phnom Penh'
                ], 
             
            ]);
        


      
	}
}
