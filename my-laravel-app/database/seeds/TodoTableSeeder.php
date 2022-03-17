<?php

use Illuminate\Database\Seeder;

class TodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("Todos")->insert([
            "title" => "task1",
            "user" => "user1",
            "created_at" => Carbon::now("Asia/Tokyo"),
            "updated_at" => Carbon::now("Asia/Tokyo")
        ]);
    }
}
