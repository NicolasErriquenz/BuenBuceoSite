angular
    .module("angularApp")
    .value('PNotify', PNotify)
    .controller("postulanteBuscarPorDniController", ["$scope", "datosEstaticosService", "adminService", "urls", "$window","$location", "$routeParams","$timeout","$rootScope",
        function ($scope, datosEstaticosService, adminService, urls, $window, $location, $routeParams, $timeout, $rootScope) {
            var vm = this;

            vm.postulanteData = [];
            
            vm.postulanteCargado = false;

            vm._recursosFotosPerfil = urls._recursosFotosPerfil;

            vm.EnvioActual = null;
            vm.seleccionarElemento = function (e) {
                vm.EnvioActual = e;
            }

            vm.busy = {
                promise: null,
                message: "Cargando..."
            };

            vm.query = {
                Documento: "",
            };

            vm.query.Documento = $routeParams.dni;
            
            $scope.promises = [];

            vm.procesandoConsulta = false;
            vm.mostrarTodosLosCampos = false;
            vm.errorSistema = "HUBO UN ERROR AL CONSEGUIR LOS DATOS DE LOS POSTULANTE. INTENTE NUEVAMENTE EN UNOS INSTANTES. SI EL PROBLEMA PERSISTE FAVOR DE COMUNICARSE AL DEPTO DE INFORMATICA A SOPORTEDESARROLLO@SPF.GOB.AR";

            vm.busy.promise = new Array();
            
            vm.OpcionesSelectMotivosRechazoDocs = ["Poca calidad en la imagen", "Archivo no pertinente", "No se aprecian todos los datos"];
            vm.Carreras = [];
            vm.Escalafones = [];
            vm.SubEscalafones = [];
            vm.OpcionesSelect = ["SI", "NO"];
            
            //vm.busy.promise = datosEstaticosService.GetCarreras(
            //    function (response) {
            //        vm.Carreras = response;
            //    },
            //    function (e) { console.log("ERROR GetCarreras", e); }
            //);

            vm.usuario = $scope.$parent.appCtrl.user().data.profile;

            vm.cargarDatosPostulante = function () {                                

                if (verifyNullUndefined(vm.query.Documento)) {
                    showDialog("VERIFIQUE EL Documento INGRESADO");
                    return;
                }

                vm.busy = {
                    promise: [],
                    message: "BUSCANDO DATOS DEL POSTULANTE..."
                };

                if (vm.mostrarLoadingDatosPostulante)
                    return;
                
                vm.mostrarLoadingDatosPostulante = true;

                vm.busy.promise.push(adminService.GetPostulanteByDni(
                    { dni: vm.query.Documento },
                    function (response) { //SUCCESS

                        vm.postulanteCargado = true;

                        vm.postulanteData = response;
                        vm.postulanteData.FechaNacimiento = new Date(vm.postulanteData.FechaNacimiento);
                        //vm.auxCadetePrimerAnio = vm.postulanteData.CadetePrimerAnio == "SI" ? "CADETE - " : "";
                        vm.mostrarLoadingDatosPostulante = false;

                        vm.postulante = response;
                        vm.getMailsAgente();
                    },
                    function (error) {
                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteCargado = false;
                    }
                ));
            };                        

            vm.getMailsAgente = function () {
                vm.busy.promise.push(adminService.GetReporteMailsAgente(
                    { dni: vm.postulanteData.Documento },
                    function (response) {
                        //console.log(response);
                        vm.ResumenEnvioMails = response;
                    },
                    function (e) {
                        console.log("ERROR ReporteMailsAgente", e);
                        showDialog(e.data.Message);
                    }
                ));
            };

            vm.checkKey = function (event) {
                //TODO
                $routeParams = { dni: vm.query.Documento };
            };

            vm.getDatosSelect = function () {
                vm.busy.promise = datosEstaticosService.GetSexo(
                    function (response) { vm.Sexos = response; },
                    function (e) { console.log("ERROR GetSexo", e); }
                );
                vm.busy.promise = datosEstaticosService.GetEstadosCiviles(
                    function (response) { vm.EstadosCiviles = response; },
                    function (e) { console.log("ERROR GetEstadosCiviles", e); }
                );
                vm.busy.promise = datosEstaticosService.GetProvincias(
                    function (response) { vm.Provincias = response; },
                    function (e) { console.log("ERROR GetProvincias", e); }
                );
                vm.busy.promise = datosEstaticosService.GetTipoNacionalidades(
                    function (response) { vm.Nacionalidades = response; },
                    function (e) { console.log("ERROR GetTipoNacionalidades", e); }
                );
                vm.busy.promise = datosEstaticosService.GetCarreras(
                    function (response) { vm.Carreras = response; },
                    function (e) { console.log("ERROR GetCarreras", e); }
                );
                vm.busy.promise = datosEstaticosService.GetUnidades(
                    function (response) { vm.Unidades = response; },
                    function (e) { console.log("ERROR GetUnidades", e); }
                );
                vm.busy.promise = datosEstaticosService.GetPostulanteEstadosPostulacion(
                    function (response) { vm.EstadosPostulante = response; },
                    function (e) { console.log("ERROR GetPostulanteEstadosPostulacion", e); }
                );
            }

            vm.getDatosSelect();

            vm.enviarMail = function () {
                $location.path("envioCorreoPorDni/" + vm.query.Documento);
            }
                        
            vm.verPerfil = function () {
                $location.path("postulante/" + vm.query.Documento);
            };

            vm.verMailsPostulante = function () {
                $location.path("mailsPostulante/" + vm.query.Documento);
            };

            vm.verDocumentacion = function () {
                $location.path("documentacionPostulante/" + vm.query.Documento);
            };
            vm.verDocumentacionMedica = function () {
                $location.path("historialCampanaPostulante/" + vm.query.Documento);
            };
            vm.estudiosMedicos = function () {
                $location.path("estudiosMedicosPostulante/" + vm.query.Documento);
            };

            vm.DescargarArchivo = function (doc) {
                var arch = doc.Archivo.replace('\\', '/');
                var urlDoc = urls._recursosDocumentacion + arch;
                $window.open(urlDoc);
            };

            vm.ModificarDatosPostulante = function (accion, flag) {
                vm.postulanteData.accion = accion;

                vm.postulanteData.SubEscalafon = null;

                console.log(vm.postulanteData);
                if (vm.mostrarLoadingDatosPostulante)
                    return;

                vm.busy = {
                    promise: null,
                    message: "BUSCANDO DATOS DEL POSTULANTE..."
                };

                vm.mostrarLoadingDatosPostulante = true;

                vm.busy.promise = (adminService.ModificarDatosPostulante(
                    vm.postulanteData,
                    function (response) { //SUCCESS
                        
                        eval("vm." + flag + " = false");
                        if (accion == 'modificarCarreraEscalafonSubEscalafon') {
                            eval("vm.flag11 = false");
                            eval("vm.flag12 = false");
                        }
                        vm.mostrarLoadingDatosPostulante = false;

                        PNotify.success({
                            title: 'REGISTRO MODIFICADO',
                            text: 'El postulante se editó con éxito',
                            type: 'success',
                            delay: 3000
                        });

                        vm.cargarDatosPostulante();
                    },
                    function (error) {
                        
                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        //vm.postulanteCargado = false;
                    }
                ));
            };

            vm.accionValidacion = "";
            vm.nombreDoc = "";
            vm.ValidarDocumento = function (doc, tipoAccion) {
                if (tipoAccion == "aceptarDocumentacion") {
                    vm.accionValidacion = "ACEPTAR";
                } else {
                    vm.accionValidacion = "RECHAZAR";
                    if (!doc.motivo || doc.motivo == "") {
                        showDialog("SELECCIONE EL MOTIVO DEL RECHAZO PRIMERO")
                        return;
                    }
                }
                vm.nombreDoc = doc.PostulanteDocumentacionTipo.Descripcion;

                if (!$window.confirm("¿Estás seguro de "+ vm.accionValidacion +" el documento "+ vm.nombreDoc+"?")) {
                    return;
                } else {
                    doc.tipoAccion = tipoAccion;

                    vm.busy = {
                        promise: [],
                        message: "ACTUALIZANDO REGISTRO..."
                    };

                    vm.busy.promise.push(adminService.ValidarDocumentosPostulante(
                        doc,
                        function (response) { //SUCCESS

                            PNotify.success({
                                title: 'REGISTRO MODIFICADO',
                                text: 'El postulante se editó con éxito',
                                type: 'success',
                                delay: 3000
                            });
                            vm.cargarDatosPostulante();
                        },
                        function (error) {
                            showDialog(error.data.Message);
                        }
                    ));
                }
            };

            vm.ReenviarCorreo = function (accion) {
                vm.postulanteData.accion = accion;

                if (vm.mostrarLoadingDatosPostulante)
                    return;

                vm.mostrarLoadingDatosPostulante = true;

                vm.busy.promise.push(adminService.ReenviarCorreo(
                    vm.postulanteData,
                    function (response) { //SUCCESS
                        vm.mostrarLoadingDatosPostulante = false;
                        PNotify.success({
                            title: 'REGISTRO EMAIL ENVIADO',
                            text: 'El correo se reenvió con éxito',
                            type: 'success',
                            delay: 3000
                        });

                    },
                    function (error) {
                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteCargado = false;
                    }
                ));
            };

            vm.ForzarValidacionEmail = function () {

                if (vm.mostrarLoadingDatosPostulante)
                    return;

                vm.mostrarLoadingDatosPostulante = true;

                vm.busy.promise.push(adminService.ForzarValidacionEmail(
                    vm.postulanteData,
                    function (response) { //SUCCESS
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteData = response;

                        PNotify.success({
                            title: 'EMAIL VALIDADO',
                            text: 'El correo fue validado correctamente',
                            type: 'success',
                            delay: 3000
                        });

                    },
                    function (error) {
                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteCargado = false;
                    }
                ));
            };

            vm.EliminarPreinscripcion = function () {

                if (vm.mostrarLoadingDatosPostulante)
                    return;

                vm.mostrarLoadingDatosPostulante = true;

                vm.busy.promise.push(adminService.EliminarPreinscripcion(
                    vm.postulanteData,
                    function (response) { //SUCCESS
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteData = response;

                        PNotify.success({
                            title: 'CODIGO DE PREINSCRIPCIÓN ELIMINADO',
                            text: 'La preinscripción se eliminó correctamente',
                            type: 'success',
                            delay: 3000
                        });

                    },
                    function (error) {
                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteCargado = false;
                    }
                ));
            };

            vm.EnviarMensaje = function () {

                if (vm.mostrarLoadingDatosPostulante)
                    return;

                if (verifyNullUndefined(vm.postulanteData.cuerpoMensaje)) {
                    showDialog("ESCRIBA UN MENSAJE PARA ENVIAR");
                    return;
                }

                vm.mostrarLoadingDatosPostulante = true;

                vm.busy.promise.push(adminService.EnviarMensaje(
                    vm.postulanteData,
                    function (response) { //SUCCESS
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteData = response;

                        PNotify.success({
                            title: 'RESPUESTA ENVIADA',
                            text: 'El correo fue enviado correctamente',
                            type: 'success',
                            delay: 3000
                        });

                    },
                    function (error) {
                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteCargado = false;
                    }
                ));
            };

            vm.ModificarUnidad = function (PostulanteCampana, flag) {
                //console.log("PostulanteCampana: " + PostulanteCampana);

                if (PostulanteCampana.UnidadId == null || PostulanteCampana.UnidadId == '') {
                    showDialog("SELECCIONE UNA UNIDAD");
                    return;
                }
                vm.busy = {
                    promise: [],
                    message: "ACTUALIZANDO REGISTRO..."
                };
                vm.busy.promise.push(adminService.ModificarUnidad(
                    PostulanteCampana,
                    function (response) { //SUCCESS
                        eval("vm." + flag + " = false");
                        PNotify.success({
                            title: 'REGISTRO MODIFICADO',
                            text: 'El postulante se editó con éxito',
                            type: 'success',
                            delay: 3000
                        });
                        vm.cargarDatosPostulante();
                    },
                    function (error) {
                        showDialog(error.data.Message);
                    }
                ));
            };
            
            vm.cancelarEdicion = function (flag) {
                eval("vm." + flag + " = false");
                vm.cargarDatosPostulante();
            };

            vm.AbrirModal = function (classModal) {
                switch (classModal) {
                    case "reset_perfil":
                        $(".confirm_dialog_reset_perfil").modal("show");
                        break;
                    case "reenviar_email":
                        $(".confirm_dialog_reenviar_email").modal("show");
                        break;
                    case "validar_email":
                        $(".confirm_dialog_validar_email").modal("show");
                        break;
                    case "reset_preinscripcion":
                        $(".confirm_dialog_reset_preinscripcion").modal("show");
                        break;
                    case "cambiar_carrera":
                        $(".confirm_dialog_cambiar_carrera").modal("show");
                        break;
                }
            };

            vm.procesandoReset = false;
            vm.BorrarPostulanteDatos = function () {
                $(".confirm_dialog_datos_basicos").modal("hide");
                if (verifyNullUndefined(vm.query.Documento)) {
                    return;
                }

                if (vm.procesandoReset)
                    return;

                vm.procesandoReset = true;

                adminService.ResetPostulanteDatos(
                    { dni: vm.query.Documento },
                    function (response) { // SUCCESS
                        vm.procesandoReset = false;
                        showDialog("Postulante Reseteado");
                        vm.cargarDatosPostulante();
                    },
                    function (e) { // ERROR
                        var mensaje = "";
                        mensaje = e.data.Message;
                        vm.procesandoReset = false;
                        showDialog(mensaje);
                    }
                );
            };

            vm.GetEscalafones = function () {

                vm.resetHabilitarCargarAmbasCarreras();

                vm.Escalafones = [];
                angular.forEach(vm.Carreras,
                    function (carrera) {
                        if (vm.postulanteData.CarreraId == carrera.Id) {
                            angular.forEach(carrera.Escalafones,
                                function (escalafon) {
                                    vm.Escalafones.push(escalafon);
                                }
                            );
                        }
                    }
                );
            }

            vm.GetSubescalafones = function () {

                //vm.postulanteData.SubescalafonId = null;

                vm.resetHabilitarCargarAmbasCarreras();

                vm.SubEscalafones = [];
                angular.forEach(vm.Escalafones,
                    function (escalafon) {
                        if (vm.postulanteData.EscalafonId == escalafon.Id) {
                            angular.forEach(escalafon.SubEscalafones,
                                function (subescalafon) {
                                    vm.SubEscalafones.push(subescalafon);
                                }
                            );
                        }
                    }
                );
            }

            vm.resetHabilitarCargarAmbasCarreras = function () {
                vm.habilitadoCargaCarreraSuboficiales = true;
                vm.habilitadoCargaCarrera = true;
            };

            vm.resetHabilitarCargarAmbasCarreras();

            vm.clearFormularios = function () {
                //vm.dni = $routeParams.dni;
                vm.postulanteCargado = false;
                vm.seleccionarRuta("postulanteBuscarPorDni/");
            };

            vm.validarRequisito = function (tipoDato, secondParam) {
                var db = vm.postulanteData.DatosBasicos;
                var respuesta;
                if (tipoDato == 'nacionalidad') {
                    respuesta = db.TipoNacionalidadId > 2;
                }
                if (tipoDato == 'edad') {
                    var edadMinima;
                    var edadMaxima;
                    if (secondParam == 'oficial') {
                        edadMinima = 17;
                        edadMaxima = 27;
                    } else {
                        edadMinima = 21;
                        edadMaxima = 35;
                    }
                    respuesta = vm.postulanteData.Edad < edadMinima || vm.postulanteData.Edad > edadMaxima;
                }
                if (tipoDato == 'separacionadminpublica') {
                    respuesta = db.SeparadoAdminPublica == "SI";
                }
                if (tipoDato == 'sancion') {
                    respuesta = db.SancionDestitucionPublica == "SI";
                }
                if (tipoDato == 'cadete1mes') {
                    respuesta = db.TipoPostulacionEpnId == 3;
                }
                if (tipoDato == 'secundario') {
                    if (secondParam == "cuerpo" && vm.postulanteData.EscalafonId == 2)
                        return;
                    if (secondParam == "administrativo" && vm.postulanteData.EscalafonId == 1)
                        return;
                    if (db.SecundarioCompleto == "SI")
                        respuesta = false;
                    if (db.SecundarioCompleto == "NO" && db.CursaUltimoAnio == "SI")
                        respuesta = false;
                    if (db.SecundarioCompleto == "NO" && db.CursaUltimoAnio == "NO")
                        respuesta = true;
                    if (secondParam == "administrativo")
                        if (db.PostulanteEstudiosTipoOrientacionId != 2 || db.PostulanteEstudiosTipoOrientacionId != 6)
                            respuesta = true;
                }
                if (tipoDato == 'sexoaltura') {
                    //if (db.SexoId == 1) { //no es excluyente, sabrina 13-05-2022
                    //    respuesta = db.Estatura < 165;
                    //}
                    //if (db.SexoId == 2) {
                    //    respuesta = db.Estatura < 162;
                    //}
                    //if (db.SexoId > 2) {
                    //    respuesta = true;
                    //}
                }
                if (tipoDato == 'estadocivil') {
                    respuesta = db.EstadoCivilId != 2 || db.TieneHijos == "SI";
                }
                if (tipoDato == 'antecedentes') {
                    respuesta = db.AntecedentesPenales == "SI";
                }
                //console.log(tipoDato, respuesta);
                if (respuesta && vm.habilitadoCargaCarrera) vm.habilitadoCargaCarrera = false;
                return respuesta;
            }

            vm.resetHabilitarCargarAmbasCarreras = function () {
                vm.habilitadoCargaCarreraSuboficiales = true;
                vm.habilitadoCargaCarrera = true;
            };

            vm.resetHabilitarCargarAmbasCarreras();

            vm.validarRequisitoSuboficial = function (tipoDato, secondParam) {
                var db = vm.postulanteData.DatosBasicos;
                var respuesta;
                if (tipoDato == 'nacionalidad') {
                    respuesta = db.TipoNacionalidadId > 2;
                }
                if (tipoDato == 'separacionadminpublica') {
                    respuesta = db.SeparadoAdminPublica == "SI";
                }
                if (tipoDato == 'sancion') {
                    respuesta = db.SancionDestitucionPublica == "SI";
                }
                if (tipoDato == 'residirprovincia') {
                    //respuesta = db.RecideTresAniosProvinciaPostulacion == "NO";
                }
                if (tipoDato == 'licenciaconducir') {
                    respuesta = db.LicenciaDeConducir == "NO";
                }
                if (tipoDato == 'edad') {
                    var edadMinima;
                    var edadMaxima;
                    if (secondParam == 'cuerpo') {
                        edadMinima = 21;
                        edadMaxima = 32;
                    }
                    if (secondParam == 'subprofesional') {
                        edadMinima = 21;
                        edadMaxima = 99;
                    }
                    if (secondParam == 'maestranza') {
                        edadMinima = 21;
                        edadMaxima = 35;
                    }
                    if (secondParam == 'oficinista') {
                        edadMinima = 21;
                        edadMaxima = 32;
                    }
                    if (secondParam == 'oficinista') {
                        edadMinima = 21;
                        edadMaxima = 32;
                    }
                    if (secondParam == 'intendencia') {
                        edadMinima = 21;
                        edadMaxima = 32;
                    }
                    respuesta = vm.postulanteData.Edad < edadMinima || vm.postulanteData.Edad > edadMaxima;
                }
                if (tipoDato == 'sexoaltura') {
                    if (db.SexoId == 1) { //no es excluyente, sabrina 13-05-2022
                        respuesta = db.Estatura < 160;
                    }
                    if (db.SexoId == 2) {
                        respuesta = db.Estatura < 155;
                    }
                    if (db.SexoId > 2) {
                        respuesta = true;
                    }
                }
                if (tipoDato == 'secundario') {

                    if (secondParam == "cuerpo") {
                        // cualquier estudio secundario da para cuerpo
                        respuesta = false;
                    }
                    if (secondParam == "intendencia") {
                        // cualquier estudio secundario da para intendencia
                        respuesta = false;
                    }
                    if (secondParam == "maestranza") {
                        // cualquier estudio secundario da para maestranza
                        respuesta = false;
                    }
                    if (secondParam == "oficinista") {
                        // cualquier estudio secundario da para maestranza
                        respuesta = false;
                    }
                    if (secondParam == "subprofesional") {
                        // cualquier estudio secundario da para intendencia
                        respuesta = db.PostulanteEstudiosTipoOrientacionId != 1 && db.PoseeTituloSuperior != "SI";
                    }

                    if (db.SecundarioCompleto == "NO" && db.CursaUltimoAnio == "NO")
                        respuesta = true;

                }
                if (tipoDato == 'sexoaltura') {
                    //if (db.SexoId == 1) { //no es excluyente, sabrina 13-05-2022
                    //    respuesta = db.Estatura < 165;
                    //}
                    //if (db.SexoId == 2) {
                    //    respuesta = db.Estatura < 162;
                    //}
                    //if (db.SexoId > 2) {
                    //    respuesta = true;
                    //}
                }
                if (tipoDato == 'antecedentes') {
                    respuesta = db.AntecedentesPenales == "SI";
                }
                //console.log(tipoDato, respuesta);
                if (respuesta && vm.habilitadoCargaCarreraSuboficiales) vm.habilitadoCargaCarreraSuboficiales = false;
                return respuesta;
            }

            vm.campAbiertas = function () {
                return function (value) {
                    return value.Campana.CampanaEstados.Id == 1;
                };
            }
                                                
            if (!verifyNullUndefined(vm.query.Documento))
                vm.cargarDatosPostulante();

            vm.seleccionarRuta = function (ruta) {
                $scope.$parent.appCtrl.seleccionarRuta(ruta);
            };

            function verifyNullUndefined(str) {
                return str === null || str === undefined || str === "";
            };

            function showDialog(m) {
                $scope.$parent.appCtrl.showDialog(m);
            };
        }]
    );