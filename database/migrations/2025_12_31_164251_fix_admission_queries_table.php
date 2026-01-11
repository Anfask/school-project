<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admission_queries', function (Blueprint $table) {
            // Make all fields nullable
            $columns = [
                'surname', 'first_name', 'email', 'mobile_1', 'mobile_2',
                'admission_sought_for_class', 'application_number', 'dob',
                'gender', 'nationality', 'address', 'previous_school_name',
                'previous_class', 'father_name', 'father_occupation',
                'mother_name', 'mother_occupation', 'additional_info',
                'status', 'remarks'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('admission_queries', $column)) {
                    Schema::table('admission_queries', function (Blueprint $table) use ($column) {
                        $table->string($column)->nullable()->change();
                    });
                }
            }

            // Change specific column types
            if (Schema::hasColumn('admission_queries', 'dob')) {
                $table->date('dob')->nullable()->change();
            }

            if (Schema::hasColumn('admission_queries', 'address')) {
                $table->text('address')->nullable()->change();
            }

            if (Schema::hasColumn('admission_queries', 'additional_info')) {
                $table->text('additional_info')->nullable()->change();
            }

            if (Schema::hasColumn('admission_queries', 'remarks')) {
                $table->text('remarks')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        // Optional rollback
    }
};
