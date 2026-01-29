<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adsense_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position'); // header, sidebar, content_top, content_middle, content_bottom, footer
            $table->text('ad_code');
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adsense_settings');
    }
};
