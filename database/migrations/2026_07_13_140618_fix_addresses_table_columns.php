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
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'phone_number')) {
                $table->renameColumn('phone_number', 'phone');
            }
            if (Schema::hasColumn('addresses', 'street_address')) {
                $table->renameColumn('street_address', 'address_line');
            }
            if (!Schema::hasColumn('addresses', 'province')) {
                $table->string('province')->nullable()->after('city');
            }
            // For instances where 'phone' still wasn't added by the rename
            if (!Schema::hasColumn('addresses', 'phone') && !Schema::hasColumn('addresses', 'phone_number')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('addresses', 'address_line') && !Schema::hasColumn('addresses', 'street_address')) {
                $table->string('address_line')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            if (Schema::hasColumn('addresses', 'phone')) {
                $table->renameColumn('phone', 'phone_number');
            }
            if (Schema::hasColumn('addresses', 'address_line')) {
                $table->renameColumn('address_line', 'street_address');
            }
            if (Schema::hasColumn('addresses', 'province')) {
                $table->dropColumn('province');
            }
        });
    }
};
