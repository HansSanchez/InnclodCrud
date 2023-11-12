<template>
    <div class="card text-uppercase">
        <div class="card-header text-uppercase">
            <div class="row">
                <div class="col-md-6">
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="p-0 m-0 breadcrumb" style="border: none !important">
                            <li class="breadcrumb-item active">
                                <router-link :to="{ name: 'documents-index' }">
                                    <b>Documentos</b>
                                </router-link>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card-body" style="background: #d7d7d7 !important">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- ENCABEZADO (BOTONES Y FILTROS) -->
                    <div class="row">

                        <!-- BOTÓN DE CREACIÓN -->
                        <div class="pt-0 mb-0 col-lg-2 col-md-6 col-sm-6 col-xs-12 pb-sm-0 pb-xs-0 mb-sm-1">
                            <button @click="update = false; resetFormDocument();" type="button" data-toggle="modal"
                                data-target="#UpdateOrCreateDocumentModal" data-backdrop="static" data-dismiss="modal"
                                class="btn btn-success text-uppercase tip-customer btn-new w-100" title="Nueva registro">
                                <v-icon color="#FFFFFF">mdi-plus-circle</v-icon>
                            </button>
                        </div>
                        <!-- END -->

                        <!-- FILTRO DE PROCESOS -->
                        <div class="pt-0 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-12 pb-sm-1 pb-xs-1">
                            <div class="mb-0 form-group">
                                <v-select :options="processes_filter" @search="setProcessesFilter" @input="queryFilter();"
                                    v-model="process_model" placeholder="PROCESOS...">
                                </v-select>
                            </div>
                        </div>
                        <!-- END -->

                        <!-- FILTRO DE TIPOS -->
                        <div class="pt-0 mb-0 col-lg-3 col-md-3 col-sm-6 col-xs-12 pb-sm-1 pb-xs-1">
                            <div class="mb-0 form-group">
                                <v-select :options="types_filter" v-model="type_model" @search="setTypesFilter"
                                    @input="queryFilter();" placeholder="TIPOS...">
                                </v-select>
                            </div>
                        </div>
                        <!-- END -->

                        <!-- FILTRO CAMPO DE BÚSQUEDA -->
                        <div class="pt-0 mb-0 col-lg-4 col-md-6 col-sm-6 col-xs-12 w-100 pb-sm-0 pb-xs-0 mb-sm-1">
                            <div class="input-group">
                                <input type="search" style="border-right: none !important" v-model="searchInput" id="search"
                                    class="form-control" @change="changeType" placeholder="Buscar..." />
                                <span class="input-group-text border-search bg-info" title="Buscar" @click="$emit('Enter')">
                                    <i class="text-white fa-solid fa-search"></i>
                                </span>
                                <span class="input-group-text border-custom bg-dark" title="Refrescar" @click="clean">
                                    <i class="text-white fa-solid fa-rotate"></i>
                                </span>
                            </div>
                        </div>
                        <!-- END -->

                    </div>
                    <!-- ENCABEZADO (BOTONES Y FILTROS) -->

                    <!-- START CREACIÓN Y ACTUALIZACIÓN -->
                    <div class="modal fade-scale" id="UpdateOrCreateDocumentModal" tabindex="-1" role="dialog"
                        aria-labelledby="UpdateOrCreateDocumentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header" style="background: #88b76e;">
                                    <h5 class="text-white modal-title text-uppercase">
                                        <b>{{ update ? 'Actualizar' : 'Nuevo' }} Registro</b>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">
                                            <v-icon style="color: #fff;">mdi-close</v-icon>
                                        </span>
                                    </button>
                                </div>
                                <div class="modal-body bv-modal">
                                    <div class="row">
                                        <div class="text-justify col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="mb-0 alert alert-info" role="alert">
                                                <h5>
                                                    <b class="full-center">
                                                        <i class="fa-solid fa-circle-info fa-2x"></i>
                                                        <strong class="pl-2">RECOMENDACIONES:</strong>
                                                    </b>
                                                </h5>
                                                <ul class="text-justify list-general">
                                                    <li class="pb-3 list-general">
                                                        <strong>
                                                            Tenga en cuenta que, los campos marcados con
                                                            <b class='text-danger'>(*)</b> son de carácter obligatorio.
                                                        </strong>
                                                    </li>
                                                    <li class="pb-3 list-general">
                                                        <strong>
                                                            El código del documento se genera de manera automática, por
                                                            ende, no es un campo editable.
                                                        </strong>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="pb-0 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <ValidationProvider name="doc_id_proceso" rules="required">
                                                <div slot-scope="{ errors }">
                                                    <div class="mb-0 form-group">
                                                        <h5><b>PROCESOS <span class="text-danger">*</span></b></h5>
                                                        <v-select :options="processes" @search="setProcesses"
                                                            @input="setProcessPrefix()" @change="generateCodeUpdate();"
                                                            v-model="FormDocument.doc_id_proceso" placeholder="ESCOGE 1...">
                                                        </v-select>
                                                    </div>
                                                    <small>
                                                        <p class="mb-0 text-danger">
                                                            <b>{{ errors[0] }}</b>
                                                        </p>
                                                    </small>
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                        <div class="pb-0 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <ValidationProvider name="doc_id_tipo" rules="required">
                                                <div slot-scope="{ errors }">
                                                    <div class="mb-0 form-group">
                                                        <h5><b>TIPOS <span class="text-danger">*</span></b></h5>
                                                        <v-select :options="types" @search="setTypes"
                                                            @input="setTypePrefix()" @change="generateCodeUpdate();"
                                                            v-model="FormDocument.doc_id_tipo" placeholder="ESCOGE 1...">
                                                        </v-select>
                                                    </div>
                                                    <small>
                                                        <p class="mb-0 text-danger">
                                                            <b>{{ errors[0] }}</b>
                                                        </p>
                                                    </small>
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                        <div class="pb-0 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <ValidationProvider name="doc_nombre" rules="required">
                                                <div slot-scope="{ errors }">
                                                    <div class="mb-0 form-group">
                                                        <h5><b>NOMBRE <span class="text-danger">*</span></b></h5>
                                                        <input v-model="FormDocument.doc_nombre" type="text"
                                                            name="doc_nombre" id="doc_nombre" class="form-control"
                                                            placeholder="Nombre del documento" required>
                                                    </div>
                                                    <small>
                                                        <b>
                                                            <em>
                                                                Escriba el nombre que desea asignarle a este
                                                                documento
                                                            </em>
                                                        </b>
                                                    </small>
                                                    <small>
                                                        <p class="mb-0 text-danger">
                                                            <b>{{ errors[0] }}</b>
                                                        </p>
                                                    </small>
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                        <div class="pb-0 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="mb-0 form-group">
                                                <h5><b>CÓDIGO</b></h5>
                                                <input v-model="FormDocument.doc_codigo" type="text" name="doc_codigo"
                                                    id="doc_codigo" class="form-control" placeholder="Código del documento"
                                                    readonly>
                                            </div>
                                            <small><b><em>Este código se genera de manera automática</em></b></small>
                                        </div>
                                        <div class="pb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <ValidationProvider name="doc_nombre" rules="required">
                                                <div slot-scope="{ errors }">
                                                    <div class="mb-0 form-group">
                                                        <h5><b>CONTENIDO <span class="text-danger">*</span></b></h5>
                                                        <textarea v-model="FormDocument.doc_contenido" type="text"
                                                            name="doc_contenido" id="doc_contenido" class="form-control"
                                                            placeholder="Contenido del documento" required
                                                            rows="10"></textarea>
                                                    </div>
                                                    <small>
                                                        <b>
                                                            <em>Escriba el contenido de este documento</em>
                                                        </b>
                                                    </small>
                                                    <small>
                                                        <p class="mb-0 text-danger">
                                                            <b>{{ errors[0] }}</b>
                                                        </p>
                                                    </small>
                                                </div>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <v-btn color="#e55353" small class="text-white btn btn-danger" data-dismiss="modal">
                                        <b>CANCELAR</b>
                                    </v-btn>
                                    <v-btn type="button" @click="createOrUpdate();" color="#2eb85c" small
                                        :disabled="validateFormDocument()" class="text-white btn btn-success text-uppercase"
                                        data-dismiss="modal">
                                        <b>{{ update ? 'Actualizar' : 'Guardar' }}</b>
                                    </v-btn>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END CREACIÓN Y ACTUALIZACIÓN -->

                    <!-- START DETALLE DEL DOCUMENTO -->
                    <div class="modal fade-scale" id="DetailDocumentModal" tabindex="-1" role="dialog"
                        aria-labelledby="DetailDocumentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header" style="background: #88b76e;">
                                    <h5 class="text-white modal-title text-uppercase">
                                        <b>Detalle del Registro</b>
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">
                                            <v-icon style="color: #fff;">mdi-close</v-icon>
                                        </span>
                                    </button>
                                </div>
                                <div class="modal-body bv-modal">
                                    <div class="row">
                                        <div class="mt-3 table-responsive max-h-650">
                                            <table id="sub_area-table"
                                                class="table bg-white table-sm table-hover table-bordered table-condensed">
                                                <thead class="headerStatic">
                                                    <tr class="text-center">
                                                        <th>ID</th>
                                                        <th>NOMBRE</th>
                                                        <th>CODIGO</th>
                                                        <th>PROCESO</th>
                                                        <th>TIPO</th>
                                                        <th>CREADO</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-if="DocDocumentDetail">
                                                        <td class="text-center text-white text-uppercase bg-register">
                                                            <b>{{ DocDocumentDetail.DOC_ID }}</b>
                                                        </td>
                                                        <td class="text-center text-">
                                                            {{ DocDocumentDetail.DOC_NOMBRE }}
                                                        </td>
                                                        <td class="text-center text-">
                                                            {{ DocDocumentDetail.DOC_CODIGO }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{
                                                                DocDocumentDetail.process ?
                                                                DocDocumentDetail.process.PRO_NOMBRE
                                                                : ""
                                                            }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{
                                                                DocDocumentDetail.type ?
                                                                DocDocumentDetail.type.TIP_NOMBRE :
                                                                ""
                                                            }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ DocDocumentDetail.CreatedLabel }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="text-center headerStatic" colspan="6">
                                                            <b>CONTENIDO</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-justify" colspan="6">
                                                            {{ DocDocumentDetail.DOC_CONTENIDO }}
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <v-btn color="#e55353" small class="text-white btn btn-danger" data-dismiss="modal">
                                        <b>CERRAR</b>
                                    </v-btn>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END DETALLE DEL DOCUMENTO -->


                    <!-- TABLA DE INFORMACIÓN -->
                    <div class="mt-3 table-responsive max-h-650">
                        <table id="sub_area-table"
                            class="table bg-white table-sm table-hover table-bordered table-condensed">
                            <thead class="headerStatic">
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>NOMBRE</th>
                                    <th>CODIGO</th>
                                    <th>CONTENIDO</th>
                                    <th>PROCESO</th>
                                    <th>TIPO</th>
                                    <th>CREADO</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in list" :key="index">
                                    <td class="text-center text-white text-uppercase bg-register">
                                        <b>{{ item.DOC_ID }}</b>
                                    </td>
                                    <td class="text-center text-">
                                        {{ item.DOC_NOMBRE }}
                                    </td>
                                    <td class="text-center text-">
                                        {{ item.DOC_CODIGO }}
                                    </td>
                                    <td class="text-justify text-lowercase">
                                        {{ truncateText(item.DOC_CONTENIDO, 100) }}
                                    </td>
                                    <td class="text-center">
                                        {{ item.process.PRO_NOMBRE }}
                                    </td>
                                    <td class="text-center">
                                        {{ item.type.TIP_NOMBRE }}
                                    </td>
                                    <td class="text-center">
                                        {{ item.CreatedLabel }}
                                    </td>
                                    <td class="text-center justify-content-center">
                                        <div class="btn-group" role="group">

                                            <!-- DETALLE DEL REGISTRO -->
                                            <span @click="update = false; writeData(item);" data-toggle="modal"
                                                title="Detalle" data-target="#DetailDocumentModal" data-backdrop="static"
                                                class="cursor-pointer text-info">
                                                <i class="fas fa-eye fa-2x"></i>
                                            </span>
                                            <!-- END -->

                                            <!-- EDITAR DEL REGISTRO -->
                                            <span @click="update = true; writeData(item);" data-toggle="modal"
                                                title="Editar" data-target="#UpdateOrCreateDocumentModal"
                                                data-backdrop="static" class="pl-2 cursor-pointer text-warning">
                                                <i class="fas fa-edit fa-2x"></i>
                                            </span>
                                            <!-- END -->

                                            <!-- ELIMINAR DEL REGISTRO -->
                                            <span @click="destroy(item); update = false" title="Eliminar"
                                                class="pl-2 cursor-pointer text-danger">
                                                <i class="fas fa-trash fa-2x"></i>
                                            </span>
                                            <!-- END -->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <infinite-loading @distance="1" :identifier="infiniteId" @infinite="infiniteHandler"
                            spinner="waveDots" ref="infiniteHandler">
                            <div slot="no-more">
                                No hay más documentos
                            </div>
                            <div slot="no-results">
                                No hay documentos
                            </div>
                        </infinite-loading>
                    </div>
                    <!-- TABLA DE INFORMACIÓN -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
/*
    COMPONENTE PARA HACER UN SCROLL INFINITO
    EL CUAL SOLO ME HACE UNA CONSULTA INICIAL DE 10 REGISTROS
    ESTO SE COMPLEMENTA CON EL CONTROLADOR Y UN SIMPLE PAGINATE
*/
import InfiniteLoading from "vue-infinite-loading";

export default {
    components: {
        InfiniteLoading,
    },
    name: "Documents",
    data() {
        return {
            id: null,
            FormDocument: {
                doc_nombre: null,
                doc_codigo: null,
                doc_contenido: null,
                doc_id_tipo: null,
                doc_id_proceso: null,
            },
            update: true,
            page: 1,
            list: [],
            DocDocumentDetail: [],
            infiniteId: +new Date(),
            searchInput: '',
            setTimeoutSearch: '',
            errors: null,
            process_model: null,
            type_model: null,
            processes: [],
            processes_filter: [],
            pro_prefix: null,
            types: [],
            types_filter: [],
            type_prefix: null,
            count_documents: 0
        };
    },
    props: {},
    methods: {
        // FUNCIÓN PARA TRAER TODOS LOS DOCUMENTOS
        infiniteHandler($state) {
            let api = "/innclod-crud/documents/getDocuments";
            axios.get(api, { params: { page: this.page, search: this.searchInput } })
                .then(({ data }) => {
                    if (data.documents.data.length > 0) {
                        this.page += 1;
                        this.list.push(...data.documents.data);
                        $state.loaded();
                    } else $state.complete();
                }).catch(error => (error.response ? this.responseErrors(error) : ""));
        },

        // FUNCIÓN PARA TRAER TODOS LOS DOCUMENTOS MEDIANTE LOS FILTROS
        queryFilter($state) {
            let api = "/innclod-crud/documents/getDocuments";
            axios.get(api, {
                params: {
                    search: this.searchInput,
                    process_model: this.process_model,
                    type_model: this.type_model,
                }
            }).then(({ data }) => {
                // VACÍO EL ARRAY PARA MOSTRAR LOS RESULTADOS DEL FILTRO
                for (let i = this.list.length; i > 0; i--) this.list.pop();

                // PINTO NUEVAMENTE LOS DATOS SEGÚN LOS FILTROS
                if (data.documents.data.length > 0) {
                    this.list.push(...data.documents.data);
                    $state.loaded();
                } else $state.complete();
            }).catch(error => (error.response ? this.responseErrors(error) : ""));
        },

        // FUNCIÓN PARA REFRESCAR LA LISTA DE DOCUMENTOS
        changeType() {
            this.page = 1;
            this.list = [];
            this.infiniteId += 1;
        },

        // FUNCIÓN PARA LIMPIEZA DE FILTROS
        clean() {
            this.searchInput = null;
            this.process_model = null;
            this.type_model = null;
            this.changeType();
        },

        // FUNCIÓN PARA CREAR O ACTUALIZAR LOS DOCUMENTOS
        createOrUpdate() {
            let url = this.update ? '/innclod-crud/documents/' + this.id + '/update' : '/innclod-crud/documents/store';
            axios.post(url, this.FormDocument)
                .then(response => {
                    this.alertLoading(response.data.timeout, response.data.msg, response.data.type)
                    if (!response.data.new) this.list.splice(this.list.findIndex(element => (element.id === response.data.doc_document.id)), 1);
                    this.list.unshift(response.data.doc_document); // UNSHIFT SIRVE PARA AGREGAR EL ELEMENTO AL ARRAY AL INICIO, PUSH LO AGREGA AL FINAL
                    this.resetFormDocument();
                }) // ES UN MÉTODO PERSONALIZADO PARA MOSTRAR UNA ALERTA CON UN SWEETALERT
                .catch(error => (error.response) ? this.responseErrors(error) : '');
        },

        async writeData(data = {}) {
            this.DocDocumentDetail = data;

            this.id = data.DOC_ID
            this.FormDocument.doc_id_proceso = {
                code: data.process.PRO_ID,
                label: data.process.PRO_NOMBRE,
            };
            this.FormDocument.doc_id_tipo = {
                code: data.type.TIP_ID,
                label: data.type.TIP_NOMBRE,
            };
            this.FormDocument.doc_nombre = data.DOC_NOMBRE
            this.FormDocument.doc_codigo = data.DOC_CODIGO
            this.FormDocument.doc_contenido = data.DOC_CONTENIDO

            this.pro_prefix = data.process.PRO_PREFIJO;
            this.type_prefix = data.type.TIP_PREFIJO;
        },

        // FUNCIÓN PARA ELIMINAR LOS DOCUMENTOS (SE IMPLEMENTÓ BORRADO LÓGICO)
        destroy(item) {
            this.$swal({
                title: '¿Realmente desea eliminar este registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, deseo eliminarlo!',
                cancelButtonText: 'Cancelar'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    axios.delete('/innclod-crud/documents/' + item.DOC_ID + '/destroy')
                        .then(response => {
                            this.alertLoading(response.data.timeout, response.data.msg, response.data.type)
                            this.list.splice(this.list.findIndex(element => (element.DOC_ID === response.data.doc_document.DOC_ID)), 1);
                        }).catch(error => (error.response) ? this.responseErrors(error) : '');
                } else this.alertLoading(5000, "Se canceló con éxito", "info")
            });
        },

        // FUNCIÓN PARA RECORTAR TEXTO MUY LARGOS
        truncateText(text, maxLength) {
            if (text.length <= maxLength) return text;
            else return text.substring(0, maxLength) + '...';
        },

        // FUNCIÓN PARA HACER UN RESET AL FORMULARIO
        resetFormDocument() {
            this.$data["FormDocument"] = this.$options.data.call(this)["FormDocument"];
        },

        // FUNCIÓN PARA VALIDAR QUE EL FORMULARIO NO TIENE CAMPOS VACÍOS
        validateFormDocument() {
            let disabled = Object.keys(this.FormDocument).some(key =>
                key !== 'doc_codigo' && (this.FormDocument[key] === null || this.FormDocument[key] === undefined || this.FormDocument[key] === ""));
            return disabled;
        },

        // FUNCIÓN PARA OBTENER EL PREFIJO DEL PROCESO
        setProcessPrefix() {
            const self = this;
            // CONSULTA PARA TRAER EL PREFIJO DEL PROCESO
            axios.get("/innclod-crud/processes/getProcessPrefix", { params: { pro_id: this.FormDocument.doc_id_proceso } })
                .then((response) => (this.pro_prefix = response.data[0]))
                .catch((error) => (error.response ? this.responseErrors(error) : ""))
                .finally(() => {
                    self.generateCode();
                    self.setCountDocuments();
                });
        },

        // FUNCIÓN PARA OBTENER EL PREFIJO DEL TIPO
        setTypePrefix() {
            const self = this;
            // CONSULTA PARA TRAER EL PREFIJO DEL TIPO
            axios.get("/innclod-crud/types/getTypePrefix", { params: { type_id: this.FormDocument.doc_id_tipo } })
                .then((response) => (this.type_prefix = response.data[0]))
                .catch((error) => (error.response ? this.responseErrors(error) : ""))
                .finally(() => {
                    self.generateCode();
                    self.setCountDocuments();
                });
        },

        // FUNCIÓN PARA OBTENER LA CANTIDAD DE DOCUMENTOS GUARDADOS
        setCountDocuments() {
            const self = this;
            // CONSULTA PARA TRAER EL PREFIJO DEL TIPO
            axios.get("/innclod-crud/documents/getCountDocuments")
                .then((response) => {
                    if (self.update) this.count_documents = response.data + 2;
                    else this.count_documents = response.data + 1;
                })
                .catch((error) => (error.response ? this.responseErrors(error) : ""))
                .finally(() => self.generateCode());
        },

        // FUNCIÓN PARA GENERAR EL CÓDIGO
        generateCode() {
            this.FormDocument.doc_codigo = this.pro_prefix + "-" + this.type_prefix + "-" + this.count_documents
        },

        // FUNCIÓN PARA GENERAR EL CÓDIGO CUANDO SE INTENTE ACTUALIZAR
        generateCodeUpdate() {
            this.setProcessPrefix();
            this.setTypePrefix();
            this.setCountDocuments();
            this.setCountDocuments();
        },

        // MÉTODO PARA TRAER LOS PROCESOS PARA EL FORMULARIO
        setProcesses(search) {
            axios.get("/innclod-crud/processes/getProcesses", { params: { search: search } })
                .then((res) => (this.processes = res.data.data))
                .catch((error) => (error.response ? this.responseErrors(error) : ""));
        },

        // MÉTODO PARA TRAER LOS PROCESOS PARA LOS FILTROS
        setProcessesFilter(search) {
            axios.get("/innclod-crud/processes/getProcessesFilter", { params: { search: search } })
                .then((res) => (this.processes_filter = res.data.data))
                .catch((error) => (error.response ? this.responseErrors(error) : ""));
        },

        // MÉTODO PARA TRAER LOS TIPOS
        setTypes(search) {
            axios.get("/innclod-crud/types/getTypes", { params: { search: search } })
                .then((res) => (this.types = res.data.data))
                .catch((error) => (error.response ? this.responseErrors(error) : ""));
        },

        // MÉTODO PARA TRAER LOS TIPOS
        setTypesFilter(search) {
            axios.get("/innclod-crud/types/getTypesFilter", { params: { search: search } })
                .then((res) => (this.types_filter = res.data.data))
                .catch((error) => (error.response ? this.responseErrors(error) : ""));
        },

        // FUNCIÓN DE ALERTA
        alertLoading(time, msg, type) {
            this.$toastr.Add({
                timeout: time,
                type: type,
                msg: msg,
            });
        },

        // FUNCIÓN PARA CONTROLAR Y PERSONALIZAR LOS ERRORES
        responseErrors(error) {
            if (error.response.status === 422) {
                // CAPTURA DE ERRORES DESDE EL BACKEND
                let msg = "";

                // RECORRE TODOS LOS ERRORES Y LOS ADJUNTA EN UNA VARIABLE
                Object.values(error.response.data.errors).map(
                    (errors, index) =>
                    (msg += `<li style="margin-bottom: 10px !important;"><b>${index + 1
                        }.</b> ${errors[0]}</li>`)
                );

                // ALERTA QUE MUESTRA AL USUARIO FINAL LOS ERRORES
                this.$swal({
                    icon: "error", // ICONO
                    title: "¡Hola! te invitamos a que revises tús campos", // TÍTULO DE LA NOTIFICACIÓN
                    html: `<ul class="text-left text-danger">${msg}</ul>`, // CONTENIDO DE LA NOTIFICACIÓN
                    showConfirmButton: true, // BOTÓN DE CONFIRMACIÓN PARA CERRAR LA VENTANA
                    timer: 15000, // 15 SEG PARA QUE EL USUARIO LEA
                    timerProgressBar: true, // PERMITE LA VISUALIZACIÓN DE UNA BARRA QUE VA INDICANDO CUANDO TIEMPO FALTA PARA QUE LA VENTANA DSE CIERRE
                });
            }

            if (error.response.status === 500) {
                this.$swal({
                    icon: "warning", // ICONO
                    title: "Oops!", // TÍTULO DE LA NOTIFICACIÓN
                    html:
                        "<p>Ocurrió un error con el servidor...</p>" +
                        '<p class="text-justify"><b class="text-warning">ADVERTENCIA:</b> ' +
                        error.response.data.msg +
                        "</p>", // CONTENIDO DE LA NOTIFICACIÓN
                    showConfirmButton: true, // BOTÓN DE CONFIRMACIÓN PARA CERRAR LA VENTANA
                    timer: 15000, // 15 SEG PARA QUE EL USUARIO LEA
                    timerProgressBar: true, // PERMITE LA VISUALIZACIÓN DE UNA BARRA QUE VA INDICANDO CUANDO TIEMPO FALTA PARA QUE LA VENTANA DSE CIERRE
                });
            }
        },
    },
    created() {
        this.setProcesses()
        this.setProcessesFilter()
        this.setTypes()
        this.setTypesFilter()
    },
};
</script>

<style scoped>
.border-search {
    cursor: pointer !important;
    border-radius: 0;
    border-top: solid 1px #000000 !important;
    border-bottom: solid 1px #000000 !important;
    border-left: 0 !important;
    border-right: 0 !important;
}

.border-custom {
    cursor: pointer !important;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    border-top: solid 1px #000000 !important;
    border-bottom: solid 1px #000000 !important;
    border-right: solid 1px #000000 !important;
    border-left: 0 !important;
}

input,
select,
v-select,
textarea,
.vdp-datepicker {
    border: 1px solid #000000 !important;
}

.vs--searchable,
.vs__dropdown-toggle {
    box-sizing: border-box;
    background: #ffffff !important;
    color: #000 !important;
    border-radius: 4px !important;
    border: 1px solid !important;
}

#preview {
    display: flex;
    justify-content: center;
    align-items: center;
}

#preview img {
    max-width: 100%;
    max-height: 500px;
}
</style>
