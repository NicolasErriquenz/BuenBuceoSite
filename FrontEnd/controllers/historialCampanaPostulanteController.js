angular
    .module("angularApp")
    .value('PNotify', PNotify)
    .controller("historialCampanaPostulanteController", ["$scope", "adminService", "urls", "$window", "$location", "$routeParams", "$timeout", "$rootScope",
        function ($scope, adminService, urls, $window, $location, $routeParams, $timeout, $rootScope) {
            var vm = this;

            vm.postulanteData = [];

            vm.postulanteCargado = false;

            vm.busy = {
                promise: null,
                message: "OBTENIENDO DATOS POSTULANTE..."
            };

            vm.query = {
                Documento: $routeParams.dni
            };

            vm.query.Documento = $routeParams.dni;

            vm.busy.promise = new Array();

            vm.getDatosPostulanteEncabezado = function () {
                vm.busy.promise.push(adminService.GetPostulanteByDniDatosMinimos(
                    { dni: $routeParams.dni },
                    function (response) {
                        vm.postulanteCargado = true;
                        vm.postulanteData = response;
                        vm.postulanteData.FechaNacimiento = new Date(vm.postulanteData.FechaNacimiento);
                        vm.mostrarLoadingDatosPostulante = false;
                    },
                    function (error) {
                        showDialog(error.data.Message);
                        vm.mostrarLoadingDatosPostulante = false;
                        vm.postulanteCargado = false;
                    }
                ));
            };
            vm.getDatosPostulanteEncabezado();

            vm.HistorialCampanasPostulante = [];
            vm.GetHistorialEstadosPostulante = function () {
                vm.busy.promise.push(adminService.GetCampanaEstadosByPostulanteDNI(
                    { PostulanteDNI: $routeParams.dni },
                    function (response) {
                        vm.PostulanteCampanaEstados = response;
                        //console.log(response);

                        var itemHistorial = {}
                        //var itemHistorial = {
                        //    encabezadoCampana: {},
                        //    etapa: [
                        //        {
                        //            datosEtapa: {},
                        //            listaEstados:
                        //                [
                        //                    {}
                        //                ]
                        //        }
                        //    ],
                        //};

                        response = response.sort((p1, p2) => (p1.CampanaId < p2.CampanaId) ? 1 : (p1.CampanaId > p2.CampanaId) ? -1 : 0);

                        var idCampanaInicial = response[0].CampanaId;;
                        var historialEtapa = [];
                        var dataEtapa = {};
                        for (var i = 0; i < response.length; i++) {
                            //debugger;
                            if (idCampanaInicial != response[i].CampanaId) {
                                //itemHistorial.etapa = [];
                                itemHistorial.encabezadoCampana = response[i - 1].Campana;
                                itemHistorial.etapa = historialEtapa;
                                vm.HistorialCampanasPostulante.push(itemHistorial);
                                itemHistorial = {}
                                historialEtapa = [];
                                idCampanaInicial = response[i].CampanaId;
                            }

                            var listaEstadosItem = [];
                            for (var j = 0; j < response[i].PostulanteCampanasEstados.length; j++) {
                                dataEtapa = {};
                                dataEtapa.infoEtapa = response[i].PostulanteCampanasEstados[j];
                                dataEtapa.etapa = response[i].PostulanteCampanasEstados[j].PostulanteCampanasEstadosTipo;
                                listaEstadosItem.push(dataEtapa);
                            }
                            dataEtapa = {};
                            dataEtapa.datosEtapa = response[i].Etapas;
                            dataEtapa.listaEstados = listaEstadosItem;
                            historialEtapa.push(dataEtapa);
                        }
                        //Agrego el último resultado
                        itemHistorial.encabezadoCampana = response[response.length-1].Campana;
                        itemHistorial.etapa = historialEtapa;
                        vm.HistorialCampanasPostulante.push(itemHistorial);

                        //console.log(vm.HistorialCampanasPostulante);
                    },
                    function (e) { console.log("ERROR GetCampanaEstadosByPostulanteDNI", e); }
                ));
            };
            vm.GetHistorialEstadosPostulante();

            vm.test = function () {

            }

            vm.test();

            vm.Volver = function () {
                $location.path("postulanteBuscarPorDni/" + $routeParams.dni);
            };

            vm.seleccionarRuta = function (ruta) {
                $scope.$parent.appCtrl.seleccionarRuta(ruta);
            };

            $scope.$on("accionarEvento", function (event, obj) {
                //console.log("Escuché al hijo");
                //console.log(obj);
                //console.log(vm.query);
                vm.query.PostulantesCampana = obj.ListaPostulantesCampana;
                vm.DataModal = obj;

                switch (obj.accionarEvento) {
                    case "mostrar_historial_estados":
                        $(".historial_estados").modal("show");
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

            function verifyNullUndefined(str) {
                return str === null || str === undefined || str === "";
            };

            function showDialog(m) {
                $scope.$parent.appCtrl.showDialog(m.toUpperCase());
            };                       

        }]
    );