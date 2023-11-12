<?php

namespace App\Http\Controllers;

use App\Models\DocDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DocDocumentoController extends Controller
{
    // FUNCIÓN DE OBTENCIÓN DE DATOS
    public function getDocuments(Request $request)
    {
        // CONSULTA DE LA PLANTACIÓN DE ÁRBOLES
        $documents = DocDocumento::withRelations() // SCOPE EN EL MODELO (RELACIONES)
            ->filter($request) // SCOPE EN EL MODELO (FILTROS)
            ->orderBy('DOC_ID', 'DESC')
            ->simplePaginate(15);
        // RESPUESTA PARA EL USUARIO
        return response()->json(['documents' => $documents]);
    }

    public function getCountDocuments()
    {
        return DocDocumento::count();
    }

    // FUNCIÓN PARA CREACIÓN
    public function store(Request $request)
    {
        // CONTROL DE ERRORES
        try {
            // VALIDACIÓN DE SESIÓN ACTIVA
            if (Auth::check()) {
                // GUARDADO DEL REGISTRO HECHO
                $doc_document = new DocDocumento($request->all());
                $doc_document->DOC_NOMBRE = mb_strtoupper($request->doc_nombre); // NOMBRE DEL DOCUMENTO
                $doc_document->DOC_CODIGO = mb_strtoupper($request->doc_codigo); // CÓDIGO AUTOMÁTICO
                $doc_document->DOC_CONTENIDO = mb_strtoupper($request->doc_contenido); // CONTENIDO DEL DOCUMENTO
                $doc_document->DOC_ID_PROCESO = $request->doc_id_proceso["code"]; // PROCESO
                $doc_document->DOC_ID_TIPO = $request->doc_id_tipo["code"]; // TIPO
                $doc_document->save(); // ALMACENAMIENTO DE LA INFORMACIÓN

                // REGISTRO DE LAS RELACIONES
                $doc_document->process;
                $doc_document->type;

                // RESPUESTA SATISFACTORIA PARA EL USUARIO
                return response()->json([
                    'timeout' => 5000,
                    'type' => 'success',
                    'msg' => 'El registro se ha realizado con éxito.',
                    'doc_document' => $doc_document,
                    'new' => true

                ]);
            } else {
                // CONTROL DE CASO DE SESIÓN EXPIRADA
                Log::error("Intento de guardado sin sesión activa - Registro de plantación de árboles");
                return response()->json([
                    'timeout' => 5000,
                    'type' => 'warning',
                    'msg' => 'La sesión se ha cerrado, por ende, no puedes hacer este registro.',
                ]);
            }
        } catch (\Exception $exception) {
            Log::error("(DocDocumentoController - store) ERROR => " . $exception->getMessage());
            return response()->json(['msg' => $exception->getMessage(), 'icon' => 'error'], 500);
        }
    }

    // FUNCIÓN PARA VISUALIZACIÓN DE DETALLE
    public function show(DocDocumento $doc_document)
    {
        // CONTROL DE ERRORES
        try {

            // RELACIONES
            $doc_document->process;
            $doc_document->type;

            // RESPUESTA PARA EL USUARIO
            return response()->json(['doc_document' => $doc_document]);
        } catch (\Exception $exception) {
            Log::error("(DocDocumentoController - show) ERROR => " . $exception->getMessage());
            return response()->json(['message' => $exception->getMessage(), 'icon' => 'error']);
        }
    }

    // FUNCIÓN PARA ACTUALIZACIÓN
    public function update(Request $request, DocDocumento $doc_document)
    {
        // CONTROL DE ERRORES
        try {

            // VALIDACIÓN DE SESIÓN ACTIVA
            if (Auth::check()) {

                // ACTUALIZACIÓN DE REGISTRO
                $doc_document->update([
                    // NOMBRE DEL DOCUMENTO
                    'DOC_NOMBRE' => mb_strtoupper($request->doc_nombre),
                    // CÓDIGO AUTOMÁTICO
                    'DOC_CODIGO' => mb_strtoupper($request->doc_codigo),
                    // CONTENIDO DEL DOCUMENTO
                    'DOC_CONTENIDO' => mb_strtoupper($request->doc_contenido),
                    // PROCESO
                    'DOC_ID_PROCESO' => $request->doc_id_proceso["code"],
                    // TIPO
                    'DOC_ID_TIPO' => $request->doc_id_tipo["code"],
                ]);

                // REGISTRO DE LAS RELACIONES
                $doc_document->process;
                $doc_document->type;

                // RESPUESTA SATISFACTORIA PARA EL USUARIO
                return response()->json([
                    'timeout' => 5000,
                    'type' => 'success',
                    'msg' => 'El registro se ha actualizado con éxito.',
                    'doc_document' => $doc_document,
                    'new' => false
                ]);
            }
        } catch (\Exception $exception) {
            Log::error("(DocDocumentoController - update) ERROR => " . $exception->getMessage());
            return response()->json(['message' => $exception->getMessage(), 'icon' => 'error']);
        }
    }

    // FUNCIÓN PARA ELIMINACIÓN (ELIMINACIÓN LÓGICA)
    public function destroy(DocDocumento $doc_document)
    {
        // CONTROL DE ERRORES
        try {

            // VALIDACIÓN DE SESIÓN ACTIVA
            if (Auth::check()) {

                // ELIMINACIÓN DEL REGISTRO
                $doc_document->delete();

                // REGISTRO DE LAS RELACIONES
                $doc_document->process;
                $doc_document->type;

                // RESPUESTA SATISFACTORIA PARA EL USUARIO
                return response()->json([
                    'timeout' => 5000,
                    'type' => 'success',
                    'msg' => 'El registro se ha actualizado con éxito.',
                    'doc_document' => $doc_document,
                ]);
            }
        } catch (\Exception $exception) {
            Log::error("(DocDocumentoController - destroy) ERROR => " . $exception->getMessage());
            return response()->json(['message' => $exception->getMessage(), 'icon' => 'error']);
        }
    }

}
