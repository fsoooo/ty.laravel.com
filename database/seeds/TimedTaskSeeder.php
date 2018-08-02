<?php

use Illuminate\Database\Seeder;

class TimedTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timed_task')->insert([
            array('task_name'=>'yd_insure','status'=>'0'),
        ]);
    }
}
