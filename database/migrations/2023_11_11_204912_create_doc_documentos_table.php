<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_documentos', function (Blueprint $table) {
            $table->id("DOC_ID");
            $table->string("DOC_NOMBRE", 60);
            $table->string("DOC_CODIGO");
            $table->longText("DOC_CONTENIDO");
            $table->foreignId("DOC_ID_TIPO")->references("TIP_ID")->on("tip_tipos");
            $table->foreignId("DOC_ID_PROCESO")->references("PRO_ID")->on("pro_procesos");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_documentos');
    }
}
