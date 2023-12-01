angular
    .module("angularApp")
    .controller("postulanteConsultaController", ["$scope", "datosEstaticosService", "adminService", "$location", "$document",
        function ($scope, datosEstaticosService, adminService, $location, $document) {
            var vm = this;

            vm.busy = {
                promise: null,
                message: "Cargando..."
            };

            $scope.promises = [];

            vm.procesandoConsulta = false;
            vm.mostrarTodosLosCampos = false;
            vm.errorSistema = "HUBO UN ERROR AL CONSEGUIR LOS DATOS DE LOS POSTULANTE. INTENTE NUEVAMENTE EN UNOS INSTANTES. SI EL PROBLEMA PERSISTE FAVOR DE COMUNICARSE AL DEPTO DE INFORMATICA A SOPORTEDESARROLLO@SPF.GOB.AR";

            vm.checkKey = function ($event) {
                $event.keyCode === 13 ? vm.getPostulantes() : null;
            };

            vm.busy.message = "Obteniendo datos...";

            vm.EstadosCiviles = [];
            vm.TipoNacionalidades = [];
            vm.TipoPostulacionesEpn = [];
            vm.Sexos = [];
            vm.Estaturas = [];
            vm.Pesos = [];
            vm.TipoOrientaciones = [];
            vm.TipoLicenciasConducir = [];
            vm.Carreras = [];
            vm.Escalafones = [];
            vm.SubEscalafones = [];
            vm.Edades = [];
            vm.EdadesMax = [];
            vm.Provincias = [];

            for (var i = 140; i < 230; i++) {
                vm.Estaturas.push(i);
            }

            for (var i = 30; i < 200; i++) {
                vm.Pesos.push(i);
            }

            for (var i = 17; i < 40; i++) {
                vm.Edades.push(i);
            }

            for (var i = 17; i < 90; i++) {
                vm.EdadesMax.push(i);
            }

            vm.getDatosSelect = function () {
                vm.busy.promise = datosEstaticosService.GetEstadosCiviles(
                    function (response) { vm.EstadosCiviles = response; },
                    function (e) { console.log("ERROR GetEstadosCiviles", e); }
                );
                vm.busy.promise = datosEstaticosService.GetProvincias(
                    function (response) { vm.Provincias = response; },
                    function (e) { console.log("ERROR GetProvincias", e); }
                );
                vm.busy.promise = adminService.GetCarreras(
                    function (response) { vm.Carreras = response; },
                    function (e) { console.log("ERROR GetCarreras", e); }
                );
                vm.busy.promise = datosEstaticosService.GetEstudiostipoOrientacion(
                    function (response) { vm.TipoOrientaciones = response; },
                    function (e) { console.log("ERROR GetEstudiostipoOrientacion", e); }
                );
                vm.busy.promise = datosEstaticosService.GetSexo(
                    function (response) { vm.Sexos = response; },
                    function (e) { console.log("ERROR GetSexo", e); }
                );
                vm.busy.promise = datosEstaticosService.GetTipoNacionalidades(
                    function (response) { vm.TipoNacionalidades = response; },
                    function (e) { console.log("ERROR GetTipoNacionalidades", e); }
                );
                vm.busy.promise = datosEstaticosService.GetTipoPostulacionesEpn(
                    function (response) { vm.TipoPostulacionesEpn = response; },
                    function (e) { console.log("ERROR GetTipoPostulacionesEpn", e); }
                );
                vm.busy.promise = datosEstaticosService.GetTipoLicenciaConducir(
                    function (response) { vm.TipoLicenciasConducir = response; },
                    function (e) { console.log("ERROR GetTipoLicenciaConducir", e); }
                );
            }

            vm.busy.promise = vm.promises;

            vm.inicializarQuery = function () {
                vm.query = {
                    Apellido: null,
                    Nombre: null,
                    Documento: null,
                    Email: null,
                    EscalafonId: null,
                    TieneHijos: null,
                    Secundario: null,
                    CarreraId: "",
                    SubEscalafonId: null,
                    PoseeTituloSuperior: null,
                    LicenciaDeConducir: null,
                    TipoLicenciaConducirId: null,
                    Estatura: null,
                    Peso: null,
                    EstadoCivilId: null,
                    TipoPostulacionEpnId: null,
                    PostulanteEstudiosTipoOrientacionId: null,
                    SexoId: null,
                    FechaRegistro: null,
                    FechaInscripcion: null,
                    PageSize: 20,
                    PageNumber: 1,
                };
            }

            vm.SelectedPage = 1;
            vm.changeSelect = function () {
                console.log(vm.SelectedPage);
                vm.getPostulantes(vm.SelectedPage);
            };

            vm.getPostulantes = function (pagina) {

                var hoy = new Date();

                if (pagina !== undefined) {
                    vm.query.PageNumber = pagina;
                    //console.log(pagina, vm.postulantePage.TotalPages);
                    if (vm.postulantePage && pagina >= vm.postulantePage.TotalPages + 1) return;
                    if (pagina < 1) return;
                }

                if (vm.query.LicenciaDeConducir == "")
                    vm.query.TipoLicenciaConducirId = null;

                //console.log(vm.query);

                if (vm.procesandoConsulta)
                    return;

                vm.procesandoConsulta = true;

                vm.postulantePage = null;
                vm.busy.message = "BUSCANDO POSTULANTES...";
                vm.busy.promise = adminService.GetConsultaPostulantesByParams(
                    vm.query,
                    function (response) { // SUCCESS
                        //console.log(vm.query)
                        vm.procesandoConsulta = false;
                        var nombreReporte = "Incorporaciones_Postulantes_" + hoy.getFullYear() + "_" + (hoy.getMonth() + 1) + "_" + hoy.getDate() + ".xlsx";
                        vm.descargarResponse(response, nombreReporte);
                        vm.procesandoConsulta = false;
                    },
                    function (e) { // ERROR
                        console.log("ERROR 1");

                        var mensaje = "";
                        mensaje = e.data.Message;

                        vm.procesandoConsulta = false;
                        vm.showDialog(vm.errorLpu);
                        //vm.showDialog(mensaje);

                    }
                );
            };

            vm.descargarResponse = function (response, nombreReporte) {
                //console.log(response);
                //var fileName = response.headers["content-disposition"].split("=")[1].replace(/\"/gi, "");
                var fileName = nombreReporte;
                var fileType = response.headers["content-type"] + ";charset=utf-8";
                var blob = new Blob([response.data], { type: fileType });
                var objectUrl = window.URL || window.webkitURL;
                var link = angular.element("<a/>");

                link.css({ display: "none" });
                link.attr({
                    href: objectUrl.createObjectURL(blob),
                    target: "_blank",
                    download: fileName
                });
                link[0].click();
                // clean up
                link.remove();
                objectUrl.revokeObjectURL(blob);
            };

            vm.GetEscalafones = function () {
                vm.Escalafones = [];
                angular.forEach(vm.Carreras,
                    function (carrera) {
                        if (vm.query.CarreraId == carrera.Id) {
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

                vm.SubEscalafones = [];
                angular.forEach(vm.Escalafones,
                    function (escalafon) {
                        if (vm.query.EscalafonId == escalafon.Id) {
                            angular.forEach(escalafon.SubEscalafones,
                                function (subescalafon) {
                                    vm.SubEscalafones.push(subescalafon);
                                }
                            );
                        }
                    }
                );
            }

            vm.getDatosSelect();
            vm.inicializarQuery();

            vm.irAMapa = function() {
                adminService.busquedaGuardada = vm.query;
                $location.path("postulanteMapa/consulta");
            };

            vm.verPerfil = function (PostulanteDni) {
                $location.path("postulanteBuscarPorDni/" + PostulanteDni);
            };

            vm.showDialog = function (m) {
                $scope.$parent.appCtrl.showDialog(m);
            };

            vm.checkPermiso = function (permiso) {
                return $scope.$parent.appCtrl.user().data ? $scope.$parent.appCtrl.user().data.profile.role.includes(permiso) : false;
            };

            $scope.getNumber = function (num) {
                return new Array(num);
            }
        }
    ]);