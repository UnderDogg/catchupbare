<?php

namespace Modules\Relations\Database\Seeds;

use Illuminate\Database\Seeder;
use Faker\Generator;


class RelationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $factory = app('Illuminate\Database\Eloquent\Factory');


        factory(\Modules\Relations\Models\Relation::class, 500)->create()->each(function($a) {
            $a->addresses()->save(factory(Modules\Relations\Models\RelationAddress::class)->make());
        });
    }
}
