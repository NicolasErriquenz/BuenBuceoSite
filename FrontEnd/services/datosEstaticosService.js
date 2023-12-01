angular
    .module("angularApp")
    .factory("datosEstaticosService", ["$resource", "urls",
        function ($resource, urls) {
            return $resource(urls.serverUrl + "api/DatosEstaticos/:id",
                { id: "@id" },
                {
                    GetOficiosTipo: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetOficiosTipo"
                    },
                    GetOficiosExpertice: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetOficiosExpertice"
                    },
                    GetTipoDocumento: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetTipoDocumentos"
                    },
                    GetTipoLicenciaConducir: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetTipoLicenciaConducir"
                    },
                    GetSexo: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetSexos"
                    },
                    GetUnidades: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetUnidades"
                    },
                    GetEstadosCiviles: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetEstadosCiviles"
                    },
                    GetPostulanteCampanaEstados: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetPostulanteCampanaEstados"
                    },
                    GetTipoPostulacionesEpn: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetTipoPostulacionesEpn"
                    },
                    GetTipoNacionalidades: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetTipoNacionalidades"
                    },
                    GetGrados: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetGrados"
                    },
                    GetEscalafones: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetEscalafones"
                    },
                    GetProvincias: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetProvincias"
                    },
                    GetEstudiosTipo: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetEstudiosTipo"
                    },
                    GetCursosTipo: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetCursosTipo"
                    },
                    GetVinculosFamiliares: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetVinculosFamiliares"
                    },
                    GetPaises: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetPaises"
                    },
                    GetCarreras: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetCarreras"
                    },
                    GetTrabajosTipo: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetTrabajosTipo"
                    },
                    GetEstudiostipoOrientacion: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetEstudiostipoOrientacion"
                    },
                    GetTipoDocumentacion: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetTipoDocumentacion"
                    },
                    GetSocialMedicoCategorias: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetSocialMedicoCategorias"
                    },
                    GetPostulanteCampanaEstadosServicio: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetPostulanteCampanaEstadosServicio"
                    },
                    GetEstadosCampana: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetEstadosCampana"
                    },
                    GetPostulanteEstadosPostulacion: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetPostulanteEstadosPostulacion"
                    },
                    GetPostulanteCampanasEstadosTipo: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/DatosEstaticos/GetPostulanteCampanasEstadosTipo"
                    },
                    all: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/unidad"
                    }
                });
        }
    ])