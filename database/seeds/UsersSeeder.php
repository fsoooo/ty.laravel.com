<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            [
                'name'=>'普通用户',
                'real_name'=>'普通用户',
                'email'=>'user@user.com',
                'phone'=>'18612345611',
                'address'=>'北京市东城区夕照寺中街14号',
                'type'=>'user',
                'code'=>'110101199901011953',
                'password'=>bcrypt('123qwe'),
            ],
            [
                'name'=>'测试用户',
                'real_name'=>'测试用户',
                'email'=>'user_inside@user.com',
                'phone'=>'18612345612',
                'address'=>'北京市东城区夕照寺中街14号',
                'type'=>'user',
                'code'=>'110101199901011954',
                'password'=>bcrypt('123qweasd'),
            ],
            [
                'name'=>'企业用户',
                'real_name'=>'公司用户',
                'email'=>'company@company.com',
                'phone'=>'18612345621',
                'address'=>'北京市东城区夕照寺中街14号',
                'type'=>'company',
                'code'=>'110101199901',
                'password'=>bcrypt('123qwe'),
            ],
            [
                'name'=>'企业用户_inside',
                'real_name'=>'公司用户_inside',
                'email'=>'company_inside@company.com',
                'phone'=>'18612345622',
                'address'=>'北京市东城区夕照寺中街14号',
                'type'=>'company',
                'code'=>'110101199',
                'password'=>bcrypt('123qweasd'),
            ]
        ]);

    }
}
