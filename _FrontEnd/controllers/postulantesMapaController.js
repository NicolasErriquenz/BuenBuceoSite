angular
    .module("angularApp")
    .controller("postulantesMapaController",
        ["$scope", "adminService", "$routeParams", "urls", "$http", "NgMap",
            function ($scope, adminService, $routeParams, urls, $http, NgMap) {
                var vm = this;

                $scope.googleMapsUrl = "https://maps.googleapis.com/maps/api/js?key=" + urls.googleMapsApiKey;

                vm.busy = {
                    promise: null,
                    message: "Cargando..."
                };

                vm._recursosFotosPerfil = urls._recursosFotosPerfil;

                $scope.promises = [];

                vm.busy.message = "Obteniendo datos...";
                vm.busy.promise = vm.promises;

                vm.TipoMapa = null;
                vm.query = null;
                vm.Params = null;
                vm.LeyendaCampana = false;
                vm.LeyendaDniPorComas = false;

                vm.Campana = [];
                vm.Postulantes = [];
                vm.ReporteConsultaPostulantes = [];

                vm.initTotales = function () {
                    vm.Totales = {
                        Verdes: 0,
                        Rojos: 0,
                        Azules: 0,
                        Grises: 0,
                    };
                }

                vm.initTotales();

                vm.GetConsultaPostulantesMapaByParams = function () {

                    vm.initTotales();

                    vm.postulantePage = null;
                    vm.busy.message = "BUSCANDO POSTULANTES...";
                    vm.busy.promise = adminService.GetConsultaPostulantesMapaByParams(
                        vm.query,
                        function (response) { // SUCCESS
                            vm.ProcesarResponse(response);
                        },
                        function (e) { // ERROR
                            console.log("ERROR 1");
                            vm.procesandoConsulta = false;
                            showDialog("ERROR AL OBTENER LOS POSTULANTES");
                        }
                    );
                }

                vm.GetCampana = function () {

                    vm.busy = {
                        promise: [],
                        message: "Cargando..."
                    };

                    vm.busy.promise.push(adminService.GetCampana(
                        { campanaId: vm.ParamId },
                        function (response) {
                            vm.Campana = response;

                            vm.postulantePage = null;
                            vm.busy.message = "BUSCANDO POSTULANTES...";
                            vm.busy.promise = adminService.GetConsultaPostulantesMapaCampana(
                                { campanaId: vm.ParamId },
                                function (response) { // SUCCESS
                                    vm.LeyendaCampana = true;
                                    vm.ProcesarResponse(response);

                                },
                                function (e) { // ERROR
                                    console.log("ERROR 1");
                                    vm.procesandoConsulta = false;
                                    showDialog("ERROR AL OBTENER LOS POSTULANTES");
                                }
                            );
                        },
                        function (e) { console.log("ERROR GetCampana", e); }
                    ));


                }


                vm.DniPorComas = null;

                vm.GetConsultaPostulantesMapaDniComas = function () {


                    vm.busy = {
                        promise: [],
                        message: "PROCESANDO LISTADO DE DNI..."
                    };

                    vm.query = {
                        DniPorComas: vm.DniPorComas,
                    }
                    vm.DniPorComas = vm.DniPorComas.replace(/ /g, "");
                    var listado = vm.DniPorComas;
                    var aListados = listado.split(",");
                    vm.DniPorComas = aListados[aListados.length - 1] !== ""
                        ? vm.DniPorComas
                        : vm.DniPorComas.slice(0, -1);

                    vm.DniPorComas = vm.DniPorComas.replace(/(\r\n|\n|\r)/gm, "");
                    vm.DniPorComas = vm.DniPorComas.replace(/\\n/g, '');
                    vm.DniPorComas = vm.DniPorComas.replace(/\\r/g, '');
                    vm.DniPorComas = vm.DniPorComas.trim();

                    vm.busy.promise = adminService.GetConsultaPostulantesMapaDniComas(
                        vm.query,
                        function (response) {
                            vm.LeyendaDniPorComas = true;
                            vm.ProcesarResponse(response);

                        },
                        function (e) {
                            console.log("ERROR GetConsultaPostulantesMapaDniComas", e);
                            showDialog(e.data.Message);
                        }
                    );


                };

                vm.ProcesarResponse = function (response) {
                    vm.ReporteConsultaPostulantes = response;

                    vm.AbrirReporte();

                    vm.Postulantes = response.Postulantes;

                    vm.CrearMarkers();
                };

                vm.Locations = [];
                vm.Markers = [];

                vm.CrearMarkers = function () {

                    if (vm.Postulantes.length > 0) {
                        var iconBlue = "https://incorporaciones.spf.gob.ar/_AdminIncorporaciones_/images/markers/blue-dot.png";
                        var iconRed = "https://incorporaciones.spf.gob.ar/_AdminIncorporaciones_/images/markers/red-dot.png";
                        var iconGreen = "https://incorporaciones.spf.gob.ar/_AdminIncorporaciones_/images/markers/green-dot.png";
                        var iconGray = "https://incorporaciones.spf.gob.ar/_AdminIncorporaciones_/images/markers/gray-dot.png";
                        for (var i = 0; i < vm.Postulantes.length; i++) {
                            var postulante = vm.Postulantes[i];
                            var PostulanteNombre = postulante.Nombres + " " + postulante.Apellido;
                            var Documento = " (" + postulante.Documento + ")";
                            var Edad = postulante.Edad;
                            var Preinscripto = postulante.Preinscripto;
                            var TelefonoCelular = postulante.TelefonoCelular;
                            var Lat = postulante.Domicilios[0].Lat;
                            var Lng = postulante.Domicilios[0].Lng;

                            var icon = null;
                            console.log("vm.LeyendaCampana", vm.LeyendaCampana);
                            if (postulante.PostulanteCampanas != null && vm.LeyendaCampana) {
                                var pc = postulante.PostulanteCampanas[0];
                                if (pc.PostulanteCampanasEstadosId === 1) {
                                    icon = iconBlue;
                                    vm.Totales.Azules++;
                                }
                                else if (pc.PostulanteCampanasEstadosId === 2) {
                                    icon = iconGreen;
                                    vm.Totales.Verdes++;
                                }
                                else if (pc.PostulanteCampanasEstadosId === 3) {
                                    icon = iconRed;
                                    vm.Totales.Rojos++;
                                } else {
                                    icon = iconGray;
                                    vm.Totales.Grises++;
                                }
                            } else {
                                if (postulante.PostulanteCampanas.length > 0) {
                                    icon = iconGreen;
                                    vm.Totales.Verdes++;
                                }
                                else {
                                    icon = iconRed;
                                    vm.Totales.Rojos++;
                                }
                            };
                            var contentString =
                                `<div style="color:black;">
                                    <div class="infowindow_title">${PostulanteNombre}</div>
                                    <div class="infowindow_content">
                                        <div class="infowindow_content_left">
                                            <b>Documento</b>: ${postulante.Documento}</br>
                                            <b>Email</b>: ${postulante.Email}</br>
                                            <b>Edad</b>: ${Edad}</br>
                                            <b>Preinscripto</b>: ${Preinscripto ? "SI" : "NO"}</br>
                                            <b>TelCelular</b>: ${TelefonoCelular}</p>
                                        </div>
                                        <div class="infowindow_content_right">
                                            <img src="${vm._recursosFotosPerfil}${postulante.FotoPerfil}" width="100"/>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="infowindow_footerLink">
                                    <a href='${urls.site_url}postulanteBuscarPorDni/${postulante.Documento}' target="_blank">Ir al Perfil</a>
                                </div>`;

                            var marker = new google.maps.Marker({
                                title: PostulanteNombre + Documento,
                                position: new google.maps.LatLng(Lat, Lng),
                                map: vm.map,
                                icon: icon + "?" + Math.floor(Math.random() * 10),
                                message: new google.maps.InfoWindow({
                                    content: contentString,
                                    maxWidth: 500
                                })
                            });

                            google.maps.event.addListener(marker, 'click', function () {
                                // When clicked, open the selected marker's message
                                this.message.open(vm.map, this);
                            });

                            vm.Markers.push(marker);
                        }

                        vm.zoomToIncludeMarkers();

                    }
                };

                vm.zoomToIncludeMarkers = function () {
                    var bounds = new google.maps.LatLngBounds();
                    for (var k1 in vm.Markers) {
                        bounds.extend(vm.Markers[k1].getPosition());
                    }
                    vm.map.fitBounds(bounds);
                };

                vm.initMap = function (callback) {
                    NgMap.getMap("mapaPostulantes").then(function (map) {
                        vm.map = map;

                        var legend = document.getElementById("legend");
                        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(legend);

                        if (callback) callback();
                    });
                };

                if ($routeParams.params != undefined) {

                    vm.map = null;

                    vm.Params = $routeParams.params;

                    if (vm.Params == "consulta") {
                        // viene de consulta - NO SE USA AUN TODO
                        vm.query = adminService.busquedaGuardada;

                        vm.GetConsultaPostulantesMapaByParams();
                    } else {
                        // viene de campaña
                        vm.TipoMapa = vm.Params.substring(0, 1);
                        vm.ParamId = vm.Params.substring(1, vm.Params.length);

                        vm.initMap(vm.GetCampana());
                    }

                } else {
                    //busqueda por dni's por comas
                    vm.query = {
                        DniPorComas: [],
                    }
                    vm.initMap();
                }

                vm.AbrirReporte = function () {
                    $("#modalReporteConsultaPostulantes").modal("show");
                };

                vm.VolverCampana = function () {
                    vm.seleccionarRuta("campanaDetalle/" + vm.ParamId);
                };

                vm.seleccionarRuta = function (ruta) {
                    $scope.$parent.appCtrl.seleccionarRuta(ruta);
                };

                function showDialog(m) {
                    $scope.$parent.appCtrl.showDialog(m);
                };

                vm.checkPermiso = function (permiso) {
                    return $scope.$parent.appCtrl.user().data ? $scope.$parent.appCtrl.user().data.profile.role.includes(permiso) : false;
                };

                function verifyNullUndefined(str) {
                    return str === null || str === undefined || str === "";
                };
            }
        ]
    )