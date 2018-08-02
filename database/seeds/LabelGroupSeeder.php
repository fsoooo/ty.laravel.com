<?php

use Illuminate\Database\Seeder;
use App\Models\SmsModel;

class LabelGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('labels')->insert([
            array('name'=>'常用标签组','parent_id'=>'0','label_type'=>'global','label_belong'=>'product','status'=>'0',),
            array('name'=>'常用标签组','parent_id'=>'0','label_type'=>'special','label_belong'=>'product','status'=>'0',),
            array('name'=>'常用标签组','parent_id'=>'0','label_type'=>'user','label_belong'=>'agent','status'=>'0',),
            array('name'=>'常用标签组','parent_id'=>'0','label_type'=>'user','label_belong'=>'user','status'=>'0',),
            array('name'=>'常用标签组','parent_id'=>'0','label_type'=>'company','label_belong'=>'user','status'=>'0',),
        ]);
    }
}


