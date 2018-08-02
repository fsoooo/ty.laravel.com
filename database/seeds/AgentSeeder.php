<?php

use Illuminate\Database\Seeder;


class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agents')->insert([
            array('user_id'=>'1','pending_status'=>'1', 'certification_status' => 1, 'work_status' => 1, 'phone' => '18612345611'),
            array('user_id'=>'2','pending_status'=>'1', 'certification_status' => 1, 'work_status' => 1, 'phone' => '18612345612'),
        ]);
        //todo send ditch
        DB::table('ditches')->insert([
            array('name'=>'渠道名称','display_name'=>'渠道全称', 'type'=>'external_group'),
        ]);
        DB::table('ditch_agent')->insert([
            array('agent_id'=>'1','ditch_id'=>'1'),
            array('agent_id'=>'2','ditch_id'=>'1'),
        ]);
    }
}
