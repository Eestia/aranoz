<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->string('slug')->unique();
            $table->longText('image_path');
            $table->longText('image2_path');
            $table->longText('image3_path');
            $table->integer('prix');
            $table->boolean('en_reduction')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->unsignedTinyInteger('reduction_pct')->nullable();
            $table->integer('stock');
            $table->foreignId('couleur_id')->constrained()->cascadeOnDelete();
            $table->foreignId('categorie_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
