<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE documentos MODIFY COLUMN tipo ENUM('Acta de nacimiento', 'CURP', 'Certificado de primaria', 'Comprobante de domicilio', 'Certificado medico')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE documentos MODIFY COLUMN tipo ENUM('Acta de nacimiento', 'CURP', 'Certificado de primaria', 'Comprobante de domicilio')");
    }
};
