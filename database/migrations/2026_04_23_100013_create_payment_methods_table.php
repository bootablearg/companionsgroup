<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('gateway', 50);
            $table->string('key', 80);
            $table->text('value')->nullable();
            $table->string('label', 120);
            $table->string('input_type', 20)->default('text');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['gateway', 'key']);
        });

        DB::table('payment_methods')->insert([
            ['gateway'=>'bank_transfer','key'=>'enabled',  'value'=>'1',  'label'=>'Habilitado',      'input_type'=>'toggle',  'sort_order'=>0,  'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'bank_transfer','key'=>'titular',  'value'=>null, 'label'=>'Titular',          'input_type'=>'text',    'sort_order'=>10, 'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'bank_transfer','key'=>'cbu',      'value'=>null, 'label'=>'CBU / CVU',        'input_type'=>'text',    'sort_order'=>20, 'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'bank_transfer','key'=>'alias',    'value'=>null, 'label'=>'Alias',            'input_type'=>'text',    'sort_order'=>30, 'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'bank_transfer','key'=>'banco',    'value'=>null, 'label'=>'Banco',            'input_type'=>'text',    'sort_order'=>40, 'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'bank_transfer','key'=>'notas',    'value'=>null, 'label'=>'Notas adicionales','input_type'=>'textarea','sort_order'=>50, 'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'mercadopago', 'key'=>'enabled',      'value'=>'0',  'label'=>'Habilitado',   'input_type'=>'toggle',  'sort_order'=>0,  'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'mercadopago', 'key'=>'public_key',   'value'=>null, 'label'=>'Public Key',   'input_type'=>'text',    'sort_order'=>10, 'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'mercadopago', 'key'=>'access_token', 'value'=>null, 'label'=>'Access Token', 'input_type'=>'password','sort_order'=>20, 'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'mercadopago', 'key'=>'sandbox',      'value'=>'1',  'label'=>'Modo Sandbox', 'input_type'=>'toggle',  'sort_order'=>30, 'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'payway',      'key'=>'enabled',      'value'=>'0',  'label'=>'Habilitado',   'input_type'=>'toggle',  'sort_order'=>0,  'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'payway',      'key'=>'merchant_id',  'value'=>null, 'label'=>'Merchant ID',  'input_type'=>'text',    'sort_order'=>10, 'created_at'=>now(),'updated_at'=>now()],
            ['gateway'=>'payway',      'key'=>'secret_key',   'value'=>null, 'label'=>'Secret Key',   'input_type'=>'password','sort_order'=>20, 'created_at'=>now(),'updated_at'=>now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
