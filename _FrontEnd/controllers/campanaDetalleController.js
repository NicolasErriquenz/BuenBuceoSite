angular
    .module("angularApp")
    .value('PNotify', PNotify)
    .controller("campanaDetalleController",
        ["$routeParams", "$scope", "$route", "adminService", "datosEstaticosService", "$rootScope", "$location", "$timeout",
            function ($routeParams, $scope, $route, adminService, datosEstaticosService, $rootScope, $location, $timeout) {
                var vm = this;

                vm.busy = {
                    promise: [],
                    message: "BUSCANDO DATOS DE CAMPAÑA..."
                };

                vm.showCard = false;

                vm.Seccion = "campanaDetalle";

                vm.DataSeleccionada = [];

                vm.TipoCalificacionId = null;

                vm.TiposCalificaciones = [
                    {
                        TipoCalificacionEtapaId: 1,
                        ListaTipos: [
                            {
                                Id: 1,
                                Descripcion: "1er etapa selección",
                            },
                            {
                                Id: 2,
                                Descripcion: "2er etapa selección",
                            },
                            {
                                Id: 3,
                                Descripcion: "3er etapa selección",
                            },
                        ],
                        FormatoCalificacion: {
                            Id: 1,
                            Descripcion: "APROBADO/DESAPROBADO"
                        },
                    },
                    {
                        TipoCalificacionEtapaId: 2,
                        ListaTipos: [
                            {
                                Id: 1,
                                Descripcion: "1er etapa test psicotécnico",
                            },
                            {
                                Id: 2,
                                Descripcion: "2er etapa test psicotécnico",
                            },
                            {
                                Id: 3,
                                Descripcion: "3er etapa test psicotécnico",
                            },
                        ],
                        FormatoCalificacion: {
                            Id: 1,
                            Descripcion: "APROBADO/DESAPROBADO"
                        },
                    },
                    {
                        TipoCalificacionEtapaId: 3,
                        ListaTipos: [
                            {
                                Id: 1,
                                Descripcion: "1er etapa test intelectual",
                            },
                            {
                                Id: 2,
                                Descripcion: "2er etapa test intelectual",
                            },
                            {
                                Id: 3,
                                Descripcion: "3er etapa test intelectual",
                            },
                        ],
                        FormatoCalificacion: {
                            Id: 2,
                            Descripcion: "NUMERO ENTERO/DECIMAL"
                        },
                    },
                    {
                        TipoCalificacionEtapaId: 4,
                        ListaTipos: [
                            {
                                Id: 1,
                                Descripcion: "1er evaluación médica",
                            },
                            {
                                Id: 2,
                                Descripcion: "2er evaluación médica",
                            },
                            {
                                Id: 3,
                                Descripcion: "3er evaluación médica",
                            },
                        ],
                        FormatoCalificacion: {
                            Id: 2,
                            Descripcion: "NUMERO ENTERO/DECIMAL"
                        },
                    },
                    {
                        TipoCalificacionEtapaId: 5,
                        ListaTipos: [
                            {
                                Id: 1,
                                Descripcion: "1er examen físico",
                            },
                            {
                                Id: 2,
                                Descripcion: "2er examen físico",
                            },
                            {
                                Id: 3,
                                Descripcion: "3er examen físico",
                            },
                        ],
                        FormatoCalificacion: {
                            Id: 2,
                            Descripcion: "NUMERO ENTERO/DECIMAL"
                        },
                    },
                ];

                vm.query = {
                    EtapaId: null,
                    CampanaId: null,
                    PostulantesCampana: [],
                    Accion: null,
                    ValorId: null
                };

                vm.query.CampanaId = $routeParams.id;

                vm.Campana = [];
                vm.EnviandoNotifiaciones = false;

                $scope.promises = [];
                vm.busy.promise = new Array();

                vm.PCeditarDato = {
                    DatoId: null, 
                    Options: [],
                };

                vm.currentEtapa = [];

                if (!verifyNullUndefined($routeParams.etapaId)) {
                    //elegirEtapa($routeParams.etapaId);
                    vm.query.EtapaId = $routeParams.etapaId;
                } else {
                    //elegirEtapa(1);
                    vm.query.EtapaId = 1;
                }

                vm.GetDatosCampanaOnly = function () {
                    vm.busy.promise.push(adminService.GetCampana(
                        vm.query,
                        //console.log(vm.query),
                        function (response) {
                            vm.Campana = response;
                        },
                        function (e) { console.log("ERROR GetCampanaOnly", e); }
                    ));
                };

                vm.GetDatosCampana = function (datosPostulante = true) {
                    vm.busy.promise.push(adminService.GetCampana(
                        vm.query,
                        function (response) {
                            vm.Campana = response;
                            vm.GetPostulantesCampana(vm.query.EtapaId);
                        },
                        function (e) { console.log("ERROR GetCampana", e); }
                    ));
                };

                vm.GetDatosCampana();

                $scope.$on("actualizar_postulantes", function (event, params) {
                    vm.GetPostulantesCampana(vm.query.EtapaId);
                });

                vm.PostulantesCampana = [];
                vm.GetPostulantesCampana = function (etapaId) {

                    //$location.url(`campanaDetalle/${vm.query.CampanaId}/${etapaId}`);

                    //$route.updateParams({ etapaId: etapaId });

                    //console.log(window.location.href);  // whatever your current location href is
                    //window.history.replaceState({}, '', `/_AdminIncorporaciones_/#!/campanaDetalle/${ vm.query.CampanaId }/${ etapaId }`);
                    //console.log(window.location.href);  // oh, hey, it replaced the path with /foo

                    //history.pushState(null, '', `/_AdminIncorporaciones_/#!/campanaDetalle/${vm.query.CampanaId}/${etapaId}`);


                    //--------------------------------------------------------
                    // Cambiar URL sin recargar la página -> Tiene problemas con botones "adelante" y "atrás" del navegador
                    //var original = $location.path;
                    //$location.path = function (path, reload) {
                    //    if (reload === false) {
                    //        var lastRoute = $route.current;
                    //        var un = $rootScope.$on('$locationChangeSuccess', function () {
                    //            $route.current = lastRoute;
                    //            un();
                    //        });
                    //    }
                    //    return original.apply($location, [path]);
                    //};

                    //$location.path(`/campanaDetalle/${vm.query.CampanaId}/${etapaId}`, false);
                    //----------------------------------------------------

                    //preventReload = function ($scope, navigateCallback) {
                    //    var lastRoute = $route.current;

                    //    $scope.$on('$locationChangeSuccess', function () {
                    //        if (lastRoute.$$route.templateUrl === $route.current.$$route.templateUrl) {
                    //            var routeParams = angular.copy($route.current.params);
                    //            $route.current = lastRoute;
                    //            navigateCallback(routeParams);
                    //        }
                    //    });
                    //};


                    //$scope.routeParams = $routeParams;
                    //preventReload($scope, function (newParams) {
                    //    $scope.routeParams = newParams;
                    //});


                    //--------------------------

                    // Cambiar URL sin recargar la página -> Resuelve problema de botones "adelante" y "atrás" del navegador
                    var original = $location.path;
                    var requestId = 0;
                    $location.path = function (param, reload) {
                        // getter
                        if (!param) return original.call($location);

                        // solo la última llamada permite hacer cosas en un ciclo de resumen
                        var currentRequestId = ++requestId;
                        if (reload === false) {
                            var lastRoute = $route.current;
                            // interceptar SOLO el siguiente $locateChangeSuccess
                            var un = $rootScope.$on('$locationChangeSuccess', function () {
                                un();
                                if (requestId !== currentRequestId) return;

                                if (!angular.equals($route.current.params, lastRoute.params)) {
                                    // esto siempre debe transmitirse cuando cambian los parámetros
                                    $rootScope.$broadcast('$routeUpdate');
                                }
                                var current = $route.current;
                                $route.current = lastRoute;
                                // hacer un cambio de ruta al trabajo de ruta anterior
                                $timeout(function () {
                                    if (requestId !== currentRequestId) return;
                                    $route.current = current;
                                });
                            });
                            // si no disparó por alguna razón, no intercepte el siguiente
                            $timeout(un);
                        }
                        return original.call($location, param);
                    };

                    $location.path(`/campanaDetalle/${vm.query.CampanaId}/${etapaId}`, false);
                    

                    vm.query = {
                        EtapaId: etapaId,
                        CampanaId: vm.Campana.Id,
                        PostulantesCampana: vm.PostulantesCampana
                    };

                    vm.busy = {
                        promise: [],
                        message: ""
                    };

                    vm.busy.message = "OBTENIENDO POSTULANTES...";

                    vm.PostulantesCampana = [];
                    vm.busy.promise.push(adminService.GetPostulantesCampana(
                        vm.query,
                        function (response) {
                            vm.query.PostulantesCampana = response;
                            //Indicaciones para el hijo
                            $scope.$broadcast("EtapaSeleccionada", vm.query);
                            $scope.$broadcast("cambiarEtapaEncabezado", vm.query.EtapaId);
                        },
                        function (e) { console.log("ERROR GetPostulantesCampana", e); }
                    ));
                }

                $scope.$on("accionarEvento", function (event, obj) {
                    //console.log("Escuché al hijo");
                    //console.log(obj);
                    //console.log(vm.query);
                    vm.query.PostulantesCampana = obj.ListaPostulantesCampana;
                    vm.DataModal = obj;

                    switch (obj.accionarEvento) {
                        case "mostrar_historial_estados": 
                        case "eliminar_ultimo_estado":
                            $(".historial_estados").modal("show");
                            break;
                        case "calificar_postulante":
                            vm.showCard = true;
                            $('#cardCalificaciones').CardWidget('maximize');

                            break;
                        default:
                            $(".generic_dialog").modal("show");
                            break;
                    }
                });

                vm.DataModal = {
                    EtapaId: null,
                    DataModalPostulantesDNI: null,
                    DataModalNombresColumna: null,
                    DataModalTitulo: null,
                    ListaPostulantesCampana: null,
                    DataModelListaDatosEstatico: null,
                    etiquetaDatoEstatico: null,
                    accionarEvento: null
                };

                vm.ConfirmarAccionModal = function (accion, listaPostulanteCampana) {
                    //console.log(accion);
                    vm.busy = {
                        promise: [],
                        message: ""
                    };

                    vm.busy.message = "PROCESANDO...";

                    switch (accion) {
                        case "modificar_estado_postulante":
                            vm.query.DatoId = vm.PCeditarDato.DatoId;
                            vm.query.FechaEdicion = vm.query.FechaEdicion;
                            //console.log(vm.query);
                            if (verifyNullUndefined(vm.query.DatoId)) {
                                showDialog("DEBE SELECCIONAR UN VALOR");
                                return;
                            }

                            vm.busy.promise.push(adminService.ModificarEstadoPostulantes(
                                vm.query, () => {
                                    vm.GetPostulantesCampana(vm.query.EtapaId);
                                    $scope.$broadcast("RefreshDatatable", 0);
                                    PNotify.success({
                                        title: 'REGISTRO MODIFICADO',
                                        text: 'El postulante se editó con éxito',
                                        type: 'success',
                                        delay: 3000
                                    });
                                },
                                function (e) {
                                    console.log("ERROR ModificarEstadoPostulantes", e);
                                    showDialog(e);
                                }
                            ));
                            break;

                        case "modificar_unidad":
                            vm.query.DatoId = vm.PCeditarDato.DatoId;
                            if (verifyNullUndefined(vm.query.DatoId)) {
                                showDialog("DEBE SELECCIONAR UN VALOR");
                                return;
                            }

                            vm.busy.promise.push(adminService.ModificarSedePostulantes(
                                vm.query,
                                function () {
                                    vm.GetPostulantesCampana(vm.query.EtapaId);
                                    $scope.$broadcast("RefreshDatatable", 0);
                                    PNotify.success({
                                        title: 'REGISTRO MODIFICADO',
                                        text: 'El postulante se editó con éxito',
                                        type: 'success',
                                        delay: 3000
                                    });
                                },
                                function (e) { console.log("ERROR ModificarSedePostulantes", e); }
                            ));

                            //console.log(listaPostulanteCampana);
                            break;

                        case "notificar_postulante":
                            adminService.dnisPorComas = listaPostulanteCampana.filter(x => x.Selected).map(x => x.Postulante.Documento).join(",");
                            vm.seleccionarRuta("envioCorreoPorDni/");
                            break;

                        case "avanzar_postulante":
                            vm.busy.promise.push(adminService.VerificarAvanzaSiguienteEtapa(
                                vm.query,
                                function (response) {
                                    if (response.length > 0) {
                                        //console.log(response);
                                        vm.DataModal.accionarEvento = 'error';
                                        vm.DataModal.ListaPostulantesCampana = response;
                                        vm.DataModal.DataModalTitulo = "ERROR: HAY POSTULANTES SIN ETAPA APROBADA";
                                        vm.DataModal.etiquetaDatoEstatico = "Ninguno de los postulantes fue insertado en la siguiente etapa. Debe revisar su selección";
                                        $(".error_dialog").modal("show");
                                        return;
                                    }

                                    vm.busy.promise.push(adminService.AvanzaSiguienteEtapa(
                                        vm.query,
                                        function (responseDuplicados) {
                                            if (responseDuplicados.length > 0) {
                                                vm.DataModal.accionarEvento = 'warning';
                                                vm.DataModal.ListaPostulantesCampana = vm.DataModal.ListaPostulantesCampana.filter(el => {
                                                    return responseDuplicados.find(element => {
                                                        return element.PostulanteId === el.PostulanteId;
                                                    });
                                                });
                                                vm.DataModal.DataModalPostulantesDNI = vm.DataModal.DataModalPostulantesDNI.filter(el => {
                                                    return vm.DataModal.ListaPostulantesCampana.find(element => {
                                                        return element.Postulante.Documento === el.Documento;
                                                    });
                                                });
                                                vm.DataModal.DataModalTitulo = "ATENCIÓN: HAY POSTULANTES QUE YA EXISTEN EN LA ETAPA SIGUIENTE";
                                                vm.DataModal.etiquetaDatoEstatico = "Los postulantes de este listado NO fueron insertados en la etapa siguiente porque fueron agregados previamente";
                                                $(".error_dialog").modal("show");                                                
                                            }
                                            vm.GetPostulantesCampana(vm.query.EtapaId + 1);
                                            $scope.$broadcast("RefreshDatatable", 0);
                                            vm.GetDatosCampanaOnly();
                                            $scope.$broadcast("RefreshNumerosEncabezado", vm.Campana);
                                            PNotify.success({
                                                title: 'REGISTRO MODIFICADO',
                                                text: 'El postulante se editó con éxito',
                                                type: 'success',
                                                delay: 3000
                                            });
                                        },
                                        function (e) {
                                            console.log("ERROR AvanzaSiguienteEtapa", e);
                                            console.log(e);
                                        }
                                    ));
                                },
                                function (e) {
                                    console.log("ERROR VerificarAvanzaSiguienteEtapa", e);
                                    showDialog(e);
                                }
                            ));
                            break;

                        case "modificar_mostrar_front":
                            vm.query.DatoId = vm.PCeditarDato.DatoId;
                            if (verifyNullUndefined(vm.query.DatoId)) {
                                showDialog("DEBE SELECCIONAR UN VALOR");
                                return;
                            }

                            vm.busy.promise.push(adminService.ModificarMostrarFront(
                                vm.query, () => {
                                    vm.GetPostulantesCampana(vm.query.EtapaId);
                                    $scope.$broadcast("RefreshDatatable", 0);
                                    PNotify.success({
                                        title: 'REGISTRO MODIFICADO',
                                        text: 'El postulante se editó con éxito',
                                        type: 'success',
                                        delay: 3000
                                    });
                                },
                                function (e) {
                                    console.log("ERROR AvanzaSiguienteEtapa", e);
                                    showDialog(e);
                                }
                            ));
                            //console.log(listaPostulanteCampana);
                            break;

                        case "aprobar_etapa":
                            vm.query.DatoId = vm.PCeditarDato.DatoId;
                            if (verifyNullUndefined(vm.query.DatoId)) {
                                showDialog("DEBE SELECCIONAR UN VALOR");
                                return;
                            }

                            vm.busy.promise.push(adminService.AprobarEtapa(
                                vm.query, () => {
                                    vm.GetPostulantesCampana(vm.query.EtapaId);
                                    $scope.$broadcast("RefreshDatatable", 0);
                                    PNotify.success({
                                        title: 'REGISTRO MODIFICADO',
                                        text: 'El postulante se editó con éxito',
                                        type: 'success',
                                        delay: 3000
                                    });
                                },
                                function (e) {
                                    console.log("ERROR aprobar_etapa", e);
                                    showDialog(e);
                                }
                            ));
                            //console.log(listaPostulanteCampana);
                            break;

                        case "eliminar_postulante_etapa":
                            //console.log(vm.query);
                            vm.busy.promise.push(adminService.QuitarDeEtapa(
                                vm.query,
                                function () {
                                    vm.GetPostulantesCampana(vm.query.EtapaId);
                                    $scope.$broadcast("RefreshDatatable", 0);
                                    vm.GetDatosCampanaOnly();
                                    $scope.$broadcast("RefreshNumerosEncabezado", vm.Campana);
                                    PNotify.success({
                                        title: 'REGISTRO MODIFICADO',
                                        text: 'El postulante se editó con éxito',
                                        type: 'success',
                                        delay: 3000
                                    });
                                },
                                function (e) {
                                    console.log("ERROR QuitarDeEtapa", e);
                                    console.log(e);
                                }
                            ));
                            //vm.busy.promise.push(adminService.VerificarQuitarDeEtapa(
                            //    vm.query,
                            //    function (response) {
                            //        if (response.length > 0) {
                            //            console.log(response);
                            //            vm.DataModal.accionarEvento = 'error';
                            //            vm.DataModal.ListaPostulantesCampana = vm.DataModal.ListaPostulantesCampana.filter(el => {
                            //                return response.find(element => {
                            //                    return element.PostulanteId === el.PostulanteId;
                            //                });
                            //            });
                            //            vm.DataModal.DataModalPostulantesDNI = vm.DataModal.DataModalPostulantesDNI.filter(el => {
                            //                return vm.DataModal.ListaPostulantesCampana.find(element => {
                            //                    return element.Postulante.Documento === el.Documento;
                            //                });
                            //            });
                            //            vm.DataModal.DataModalTitulo = "ERROR: HAY POSTULANTES EXISTENTENTES EN LA ETAPA SIGUIENTE";
                            //            vm.DataModal.etiquetaDatoEstatico = "Los postulantes de este listado deben ser quitados de la etapa siguiente. NINGÚN POSTULANTE FUE REMOVIDO DE LA ETAPA ACTUAL";
                            //            $(".error_dialog").modal("show");
                            //            return;
                            //        }
                            //        vm.busy.promise.push(adminService.QuitarDeEtapa(
                            //            vm.query,
                            //            function () {
                            //                vm.GetPostulantesCampana(vm.query.EtapaId);
                            //                $scope.$broadcast("RefreshDatatable", 0);
                            //                PNotify.success({
                            //                    title: 'REGISTRO MODIFICADO',
                            //                    text: 'El postulante se editó con éxito',
                            //                    type: 'success',
                            //                    delay: 3000
                            //                });
                            //            },
                            //            function (e) {
                            //                console.log("ERROR QuitarDeEtapa", e);
                            //                console.log(e);
                            //            }
                            //        ));
                            //    },
                            //    function (e) {
                            //        console.log("ERROR VerificarQuitarDeEtapa", e);
                            //        showDialog(e);
                            //    }
                            //));
                            break;

                        case "eliminar_ultimo_estado":
                            if (listaPostulanteCampana[0].PostulanteCampanasEstados[listaPostulanteCampana[0].PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Listado == false) {
                                showDialog("NO ES POSIBLE ELIMINAR UN ESTADO ASIGNADO POR EL SISTEMA");
                                return;
                            };
                            vm.query.DatoId = listaPostulanteCampana[0].PostulanteId;
                            //console.log(vm.query);
                            vm.busy.promise.push(adminService.EliminarUltimoEstadoPostulante(
                                vm.query,
                                function () {
                                    vm.GetPostulantesCampana(vm.query.EtapaId);
                                    $scope.$broadcast("RefreshDatatable", 0);
                                    PNotify.success({
                                        title: 'REGISTRO MODIFICADO',
                                        text: 'El postulante se editó con éxito',
                                        type: 'success',
                                        delay: 3000
                                    });
                                },
                                function (e) {
                                    console.log("ERROR EliminarUltimoEstadoPostulante()", e);
                                    showDialog("HUBO UN ERROR");
                                }
                            ));
                            break;
                        case "calificar_postulante":
                            vm.query.DatoId = vm.PCeditarDato.DatoId;
                            vm.query.FechaEdicion = vm.query.FechaEdicion;
                            var informarError = false;

                            //console.log(vm.TipoCalificacionId);

                            if (vm.TipoCalificacionId == null) {
                                showDialog("Seleccione un tipo de calificación");
                                break;
                            }

                            //Si es nota grupal y numérica -> Asigno la notaNumerica global al grupo
                            if (vm.CheckNotaGrupal == true && vm.ValorCalificacionGrupalNumeric != null) {
                                for (var i = 0; i < vm.query.PostulantesCampana.length; i++) {
                                    vm.query.PostulantesCampana[i].Postulante.NotaNumeric = vm.ValorCalificacionGrupal;
                                }
                            }

                            //Si es nota grupal y textual DESAPROBADO -> Asigno la nota global al grupo y genero la notaNumerica
                            if (vm.CheckNotaGrupal == true && vm.ValorCalificacionGrupal == 1) {                                
                                for (var i = 0; i < vm.query.PostulantesCampana.length; i++) {
                                    vm.query.PostulantesCampana[i].Postulante.Nota = vm.ValorCalificacionGrupal;
                                    vm.query.PostulantesCampana[i].Postulante.NotaNumeric = 0;
                                }
                            }

                            //Si es nota grupal y textual APROBADO -> Asigno la nota global al grupo y genero la notaNumerica
                            if (vm.CheckNotaGrupal == true && vm.ValorCalificacionGrupal == 2) {
                                for (var i = 0; i < vm.query.PostulantesCampana.length; i++) {                                    
                                    vm.query.PostulantesCampana[i].Postulante.Nota = vm.ValorCalificacionGrupal;
                                    vm.query.PostulantesCampana[i].Postulante.NotaNumeric = 10;
                                }
                            }

                            let formatoCalificacion = vm.TiposCalificaciones.filter(x => x.TipoCalificacionEtapaId == vm.query.EtapaId);
                            formatoCalificacion = formatoCalificacion[0].FormatoCalificacion.Id;

                            //console.log(vm.query);
                            for (var i = 0; i < vm.query.PostulantesCampana.length; i++) {
                                if (formatoCalificacion == 2 && vm.query.PostulantesCampana[i].Postulante.NotaNumeric == null) {
                                    console.log("Pintar celda en rojo del postulante numeric: " + vm.query.PostulantesCampana[i].Postulante.Documento);
                                    informarError = true;
                                }
                                if (formatoCalificacion == 1 && vm.query.PostulantesCampana[i].Postulante.Nota == null) {
                                    console.log("Pintar celda en rojo del postulante string: " + vm.query.PostulantesCampana[i].Postulante.Documento);
                                    informarError = true;
                                }
                            }

                            if (informarError) {
                                showDialog("Hay postulantes sin calificación");
                            } else {
                                $('#cardCalificaciones').CardWidget('minimize');
                                vm.clearInput();
                                //getPostulantes ...
                                //refreshDatatable() ...
                                //PNotify.success ...
                            }
                            console.log(vm.query.PostulantesCampana);

                            break;   
                    }
                    $('.generic_dialog').modal('hide');
                };

                //vm.NotificarPostulanteCampana = function () {

                //    vm.PostulanteCampanaNotificar.Notificando = true;
                //    $(".confirm_notificar_postulante").modal("hide");
                //    vm.busy = {
                //        promise: [],
                //        message: ""
                //    };

                //    vm.busy.message = "NOTIFICANDO POSTULANTE...";

                //    vm.busy.promise.push(adminService.EnviarMailNotificacionIndividual(
                //        vm.PostulanteCampanaNotificar,
                //        function (response) {
                //            PNotify.success({
                //                title: 'POSTULANTE NOTIFICADO',
                //                text: 'El postulante fue notificado de la campaña',
                //                type: 'success',
                //                delay: 3000
                //            });

                //            vm.PostulanteCampanaNotificar.Notificando = false;

                //            vm.PostulanteCampanaNotificar = response;
                //            var index = vm.PostulantesCampana.findIndex(function (o) {
                //                return o.Id === vm.PostulanteCampanaNotificar.Id;
                //            });
                //            if (index !== -1) {
                //                vm.PostulantesCampana[index] = response;
                //            }

                //        },
                //        function (e) {
                //            console.log("ERROR NotificarPostulantesCampana", e);
                //            showDialog(e.data.Message);
                //            vm.PostulanteCampanaNotificar.Notificando = false;
                //        }
                //    ));
                //};

                //vm.GuardarCambioUnidad = function () {
                //    if (vm.PCeditarUnidad.UnidadId == null) {
                //        showDialog("DEBE SELECCIONAR UNA UNIDAD");
                //        return;
                //    }

                //    vm.query = {
                //        ListadoDni: vm.getDnisSeleccionados(),
                //        UnidadesId: vm.PCeditarUnidad.UnidadId
                //    };
                //    vm.busy = {
                //        promise: [],
                //        message: "ACTUALIZANDO REGISTROS..."
                //    };
                //    vm.busy.promise.push(adminService.ActualizarSedeDniComas(
                //        vm.query,
                //        function (response) { //SUCCESS
                //            PNotify.success({
                //                title: 'REGISTROS MODIFICADO',
                //                text: 'Los postulantes se editaron con éxito',
                //                type: 'success',
                //                delay: 3000
                //            });

                //            vm.GetDatosCampana();
                //        },
                //        function (error) {
                //            showDialog(error.data.Message);
                //        }
                //    ));
                //    $('#modalUnidadElegida').modal('hide');
                //};

                vm.resetCheckGrupal = function () {
                    for (var i = 0; i < vm.query.PostulantesCampana.length; i++) {
                        vm.query.PostulantesCampana[i].Postulante.Nota = null;
                        vm.query.PostulantesCampana[i].Postulante.NotaNumeric = null;
                    }
                    vm.ValorCalificacionGrupal = null;
                    vm.ValorCalificacionGrupalNumeric = null;
                };

                vm.clearInput = function () {
                    //console.log(vm.query.PostulantesCampana);

                    for (var i = 0; i < vm.query.PostulantesCampana.length; i++) {
                        vm.query.PostulantesCampana[i].Postulante.Nota = null;
                        vm.query.PostulantesCampana[i].Postulante.NotaNumeric = null;
                    }
                    vm.ValorCalificacionGrupal = null;
                    vm.ValorCalificacionGrupalNumeric = null;
                    vm.query.FechaEdicion = null;
                    vm.TipoCalificacionId = null;
                    vm.CheckNotaGrupal = false;
                    vm.showCard = false;
                };

                function CleanStringUtf8Chars(s, a, b) {
                    return replaceAll(s, "ó", "o")
                    //.replaceAll(s, "É", "E")
                    //.replaceAll(s, "Í", "I")
                    //.replaceAll(s, "Ó", "O")
                    //.replaceAll(s, "Ú", "U")
                    //.replaceAll(s, "á", "a")
                    //.replaceAll(s, "é", "e")
                    //.replaceAll(s, "í", "i")
                    //.replaceAll(s, "ó", "o")
                    //.replaceAll(s, "í", "u")
                    //.replaceAll(s, "Ñ", "N")
                    //.replaceAll(s, "ñ", "n");
                }
                function replaceAll(str, find, replace) {
                    return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
                }

                function escapeRegExp(string) {
                    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
                }

                vm.GotoMapa = function () {
                    vm.seleccionarRuta("postulanteMapa/c" + vm.Campana.Id);
                };

                vm.seleccionarRuta = function (ruta) {
                    $scope.$parent.appCtrl.seleccionarRuta(ruta);
                };

                function showDialog(m) {
                    $scope.$parent.appCtrl.showDialog(m.toUpperCase());
                };

                function verifyNullUndefined(str) {
                    return str === null || str === undefined || str === "";
                };

                vm.ModalObj = {
                    Titulo: "",
                    ListPostulantes: [],
                    tipo: ""
                };
                //return del modal
                vm.ModalAceptado = function() {
                    if (vm.ModalObj.tipo = "") {
                        vm.busy.promise.push(adminService.GetCampana(
                            vm.ModalObj,
                            function (response) {
                                vm.GetPostulantesCampana();
                            },
                            function (e) { console.log("ERROR GetCampana", e); }
                        ));
                    }

                    if (vm.ModalObj.tipo = "") {
                        vm.busy.promise.push(adminService.GetCampana(
                            vm.ModalObj,
                            function (response) {
                                vm.GetPostulantesCampana();
                            },
                            function (e) { console.log("ERROR GetCampana", e); }
                        ));
                    }
                };
                
            }]
            
    );