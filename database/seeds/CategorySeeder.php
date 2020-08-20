<?php

use Illuminate\Database\Seeder;
use \App\Models\Category;
use \App\Models\SubCategory;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryItems = [
            [
                'name'          => 'Novels',
                'description'   => '',
                'sub_categories'=>  [
                    [
                        'name'          => 'Fantasy',
                        'description'   => '',
                    ],
                    [
                        'name'          => 'Historical',
                        'description'   => '',
                    ],
                    [
                        'name'          => 'Horror',
                        'description'   => '',
                    ],
                    [
                        'name'          => 'Mysteries',
                        'description'   => '',
                    ],
                    [
                        'name'          => 'Romance',
                        'description'   => '',
                    ],
                    [
                        'name'          => 'Science Fiction',
                        'description'   => '',
                    ],
                    [
                        'name'          => 'Thrillers',
                        'description'   => '',
                    ],
                    [
                        'name'          => 'Westerns',
                        'description'   => '',
                    ],

                ]
            ],
            [
                'name'          => 'Children',
                'description'   => '',
                'sub_categories'=>  [
                    [
                        'name'          => 'Drawing',
                        'description'   => '',
                    ],
                    [
                        'name'          => 'Story',
                        'description'   => '',
                    ],
                    [
                        'name'          => 'Others',
                        'description'   => '',
                    ],
                ]
            ],
            [
            'name'          => 'College',
            'description'   => '',
            'sub_categories'=>  [
                [
                    'name'          => 'Agriculture',
                    'description'   => '',
                ],
                [
                    'name'          => 'Arts',
                    'description'   => '',
                ],
                [
                    'name'          => 'Engineering',
                    'description'   => '',
                ],
                [
                    'name'          => 'Law',
                    'description'   => '',
                ],
                [
                    'name'          => 'Medicine',
                    'description'   => '',
                ],
            ]
        ]

        ];



        /*
         * Add Category Items
         *
         */
        DB::transaction(function() use ($categoryItems) {
            if( count($categoryItems) > 0 ){
                foreach ($categoryItems as $categoryItem) {
                    $category = Category::where('name',  $categoryItem['name'])->first();
                    if ( is_null($category) ){
                        $category = Category::create(['name'=>$categoryItem['name'],'description'=>$categoryItem['description']]);
                    }
                    if ( !is_null($category) ){
                        if( count($categoryItem['sub_categories']) > 0 ){
                            foreach ( $categoryItem['sub_categories'] as $subCategoryItem ){
                                $subCategoryItem['category_id'] = $category['id'];
                                $subCategory = SubCategory::where('name',  $subCategoryItem['name'])->where('category_id',$category['id'])->first();
                                if( is_null($subCategory) )
                                    SubCategory::create($subCategoryItem);
                            }
                        }
                    }

                }
            }
        });

    }
}
