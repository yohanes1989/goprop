<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_categories', function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
        });

        Schema::create('packages', function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('fee_description', 255)->nullable();
            $table->text('commission');
            $table->integer('package_category_id')->nullable()->unsigned();
            $table->integer('sort_order')->default(0)->nullable();
            $table->string('css_class', 255)->nullable();
            $table->timestamps();

            $table->foreign('package_category_id')->references('id')->on('package_categories')->onDelete('SET NULL');
        });

        Schema::create('package_features', function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('code', 255)->nullable()->unique();
        });

        Schema::create('package_package_feature', function(Blueprint $table){
            $table->integer('package_id')->nullable()->unsigned();
            $table->integer('package_feature_id')->nullable()->unsigned();
            $table->decimal('price', 14, 2)->nullable();
            $table->integer('sort_order')->default(0)->nullable();

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('CASCADE');
            $table->foreign('package_feature_id')->references('id')->on('package_features')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_package_feature', function(Blueprint $table){
            $table->dropForeign('package_package_feature_package_id_foreign');
            $table->dropForeign('package_package_feature_package_feature_id_foreign');
        });

        Schema::table('packages', function(Blueprint $table){
            $table->dropForeign('packages_package_category_id_foreign');
        });

        Schema::drop('package_package_feature');
        Schema::drop('package_features');
        Schema::drop('packages');
        Schema::drop('package_categories');
    }
}
