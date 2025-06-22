angular
    .module("angularApp")
    .factory("adminService", ["$resource", "urls",
        function ($resource, urls) {
            return $resource(
                urls.serverUrl + "api/home/",
                { id: "@id" },
                {
                    GetConsultaPostulantesByParams: {
                        method: 'post',
                        responseType: 'arraybuffer',
                        transformResponse: function (data, headers) {
                            var response = {};
                            response.data = data;
                            response.headers = headers();
                            response.nombre = headers().Nombre;

                            return response;
                        },
                        url: urls.serverUrl + "api/administrador/GetConsultaPostulantesByParams/"
                    },
                    DescargarPostulantesCampana: {
                        method: 'post',
                        responseType: 'arraybuffer',
                        transformResponse: function (data, headers) {
                            var response = {};
                            response.data = data;
                            response.headers = headers();
                            response.nombre = headers().Nombre;

                            return response;
                        },
                        url: urls.serverUrl + "api/administrador/DescargarPostulantesCampana/"
                    },
                    GetConsultaPostulantesMapaByParams: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/GetConsultaPostulantesMapaByParams"
                    },
                    GetConsultaPostulantesMapaCampana: {
                        method: "GET",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/GetConsultaPostulantesMapaCampana"
                    },
                    GetConsultaPostulantesMapaDniComas: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/GetConsultaPostulantesMapaDniComas"
                    },
                    GetCarreras: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/administrador/GetCarreras"
                    },
                    GetPostulantesByParams: {
                        method: "GET",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/GetPostulantesByParams"
                    },
                    GetPostulanteByDni: {
                        method: "GET",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/GetPostulanteByDni"
                    },
                    GetPostulanteByDniDatosMinimos: {
                        method: "GET",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/GetPostulanteByDniDatosMinimos"
                    },
                    BorrarPostulanteDatos: {
                        method: "GET",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/BorrarPostulanteDatos"
                    },
                    ResetPostulanteDatos: {
                        method: "GET",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/ResetPostulanteDatos"
                    },
                    TestEmail: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/TestEmail"
                    },
                    NotificarPostulantesCampana: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/NotificarPostulantesCampana"
                    },
                    BorrarPostulantesCampana: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/BorrarPostulantesCampana"
                    },
                    EnviarMailNotificacionIndividual: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/EnviarMailNotificacionIndividual"
                    },
                    ModificarDatosPostulante: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/ModificarDatosPostulante"
                    },
                    ReenviarCorreo: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/ReenviarCorreo"
                    },
                    ForzarValidacionEmail : {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/ForzarValidacionEmail "
                    },                    
                    EliminarPreinscripcion: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/EliminarPreinscripcion "
                    },
                    EnviarMensaje: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/EnviarMensaje "
                    },
                    ValidarDocumentosPostulante: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/ValidarDocumentosPostulante "
                    },
                    CrearCampana: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/CrearCampana",
                        transformResponse: function (data) {
                            return { data: angular.fromJson(data) };
                        }
                    },
                    EditarCampana: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/EditarCampana",
                        transformResponse: function (data) {
                            return { data: angular.fromJson(data) };
                        }
                    },
                    GetCampana: {
                        method: "GET",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/GetCampana"
                    },
                    GetPostulantesCampana: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/administrador/GetPostulantesCampana"
                    },
                    GetCampanaEstadosByPostulanteDNI: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/administrador/GetCampanaEstadosByPostulanteDNI"
                    },
                    AgregarPostulantesCampana: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/AgregarPostulantesCampana"
                    },
                    ProcesarEnvioMasivoMails: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/ProcesarEnvioMasivoMails"
                    },
                    CancelarCampana: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/CancelarCampana"
                    },
                    CerrarCampana: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/CerrarCampana"
                    },
                    ModificarEstadoPostulanteCampana: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/ModificarEstadoPostulanteCampana"
                    },
                    ActualizarSedeDniComas: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/administrador/ActualizarSedeDniComas"
                    },
                    ModificarEstadoPostulantes: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/campana/ModificarEstadoPostulantes"
                    },
                    ModificarSedePostulantes: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/campana/ModificarSedePostulantes"
                    },
                    ModificarMostrarFront: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/campana/ModificarMostrarFront"
                    },
                    VerificarAvanzaSiguienteEtapa: {
                        method: "POST",
                        isArray: true,
                        url: urls.serverUrl + "api/campana/VerificarAvanzaSiguienteEtapa"
                    },
                    AvanzaSiguienteEtapa: {
                        method: "POST",
                        isArray: true,
                        url: urls.serverUrl + "api/campana/AvanzaSiguienteEtapa"
                    },
                    VerificarQuitarDeEtapa: {
                        method: "POST",
                        isArray: true,
                        url: urls.serverUrl + "api/campana/VerificarQuitarDeEtapa"
                    },
                    QuitarDeEtapa: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/campana/QuitarDeEtapa"
                    },
                    AprobarEtapa: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/campana/AprobarEtapa"
                    },
                    EliminarUltimoEstadoPostulante: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/campana/EliminarUltimoEstadoPostulante"
                    },
                    EliminarPostulanteDeEtapaCampana: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "api/campana/EliminarPostulanteDeEtapaCampana"
                    },
                    CargarCampanas: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/administrador/CargarCampanas"
                    },
                    GetReporteMails: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/administrador/GetReporteMails"
                    },
                    GetReporteMailsAgente: {
                        method: "GET",
                        isArray: true,
                        url: urls.serverUrl + "api/administrador/GetReporteMailsAgente"
                    },
                    busquedaGuardada: {},
                    dnisPorComas: "",
                }
            );
        }
    ]);