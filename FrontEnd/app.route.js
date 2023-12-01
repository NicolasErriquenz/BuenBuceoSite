angular
    .module("angularApp")
    .config(function ($routeProvider) {
        var views = "./views/";
        $routeProvider.caseInsensitiveMatch = true;
        $routeProvider
            .when("/",
                {
                    controller: "homeController",
                    controllerAs: "homeCtrl",
                    templateUrl: views + "home/home.html"
                })
            .when("/envioCorreoPorDni/:dni?",
                {
                    controller: "envioCorreoPorDniController",
                    controllerAs: "envioCorreoPorDniCtrl",
                    templateUrl: views + "postulante/envioCorreoPorDni.html",
                    access: {
                        permissions: ["Incorporaciones.PostulanteConsulta"]
                    }
                })
            .when("/reporteEnvioCorreoPorDni",
                {
                    controller: "reporteEnvioCorreoPorDniController",
                    controllerAs: "reporteEnvioCorreoPorDniCtrl",
                    templateUrl: views + "postulante/reporteEnvioCorreoPorDni.html",
                    access: {
                        permissions: ["Incorporaciones.PostulanteConsulta"]
                    }
                })
            .when("/postulanteConsulta",
                {
                    controller: "postulanteConsultaController",
                    controllerAs: "postulanteConsultaCtrl",
                    templateUrl: views + "postulante/postulanteConsulta.html",
                    access: {
                        permissions: ["Incorporaciones.PostulanteConsulta"]
                    }
                })
            .when("/postulanteMapa/:params?",
                {
                    controller: "postulantesMapaController",
                    controllerAs: "postulantesMapaCtrl",
                    templateUrl: views + "postulante/postulantesMapa.html",
                    access: {
                        permissions: ["Incorporaciones.PostulanteConsulta"]
                    }
                })
            .when("/postulante/:dni",
                {
                    controller: "postulanteDetalleController",
                    controllerAs: "postulanteDetalleCtrl",
                    templateUrl: views + "postulante/postulanteDetalle.html",
                    access: {
                        permissions: ["Incorporaciones.PostulanteConsulta"]
                    }
                })
            .when("/postulanteBuscarPorDni/:dni?",
                {
                    controller: "postulanteBuscarPorDniController",
                    controllerAs: "postulanteBuscarPorDniCtrl",
                    templateUrl: views + "postulante/postulanteBuscarPorDni.html",
                    access: {
                        permissions: ["Incorporaciones.PostulanteConsulta"]
                    }
                })
            .when("/documentacionPostulante/:dni?",
                {
                    controller: "documentacionPostulanteController",
                    controllerAs: "documentacionPostulanteCtrl",
                    templateUrl: views + "postulante/documentacionPostulante.html",
                    access: {
                        permissions: ["Incorporaciones.PostulanteConsulta"]
                    }
                })
            .when("/mailsPostulante/:dni?",
                {
                    controller: "mailsPostulanteController",
                    controllerAs: "mailsPostulanteCtrl",
                    templateUrl: views + "postulante/mailsPostulante.html",
                    access: {
                        permissions: ["Incorporaciones.PostulanteConsulta"]
                    }
                })
            .when("/campanaAgregar",
                {
                    controller: "campanaAgregarController",
                    controllerAs: "campanaAgregarCtrl",
                    templateUrl: views + "campana/campanaAgregar.html",
                    access: {
                        permissions: ["Incorporaciones.CampañasAgregar"]
                    }
                })
            .when("/campanaEditar/:id",
                {
                    controller: "campanaEditarController",
                    controllerAs: "campanaEditarCtrl",
                    templateUrl: views + "campana/campanaEditar.html",
                    access: {
                        permissions: ["Incorporaciones.CampañasEditar"]
                    }
                })
            .when("/campanasListado",
                {
                    controller: "campanasListadoController",
                    controllerAs: "campanasListadoCtrl",
                    templateUrl: views + "campana/campanasListado.html",
                    access: {
                        permissions: ["Incorporaciones.Campañas"]
                    }
                })
            .when("/campanaDetalle/:id/:etapaId?/:dni?",
                {
                    controller: "campanaDetalleController",
                    controllerAs: "campanaDetalleCtrl",
                    templateUrl: views + "campana/campanaDetalle.html",
                    access: {
                        permissions: ["Incorporaciones.Campañas"]
                    }
                })
                 .when("/campanaDetalle/:id/:etapaId?/:dni?",
                {
                    controller: "campanaDetalleController",
                    controllerAs: "campanaDetalleCtrl",
                    templateUrl: views + "campana/campanaDetalle.html",
                    access: {
                        permissions: ["Incorporaciones.Campañas"]
                    }
                })
            .when("/editarDatosEstaticos",
                {
                    controller: "datosEstaticosController",
                    controllerAs: "datosEstaticosCtrl",
                    templateUrl: views + "datosEstaticos/datosEstaticos.html",
                    access: {
                        permissions: ["Incorporaciones.ModificarDatosEstaticos"]
                    }
                })
            .when("/calificaciones",
                {
                    controller: "calificacionesController",
                    controllerAs: "calificacionesCtrl",
                    templateUrl: views + "postulante/calificaciones.html",
                })
            .when("/historialCampanaPostulante/:dni?",
                {
                    controller: "historialCampanaPostulanteController",
                    controllerAs: "historialCampanaPostulanteCtrl",
                    templateUrl: views + "postulante/historialCampanaPostulante.html",
                })
            .when("/estudiosMedicosPostulante/:dni?",
                {
                    controller: "documentacionPostulanteController",
                    controllerAs: "documentacionPostulanteCtrl",
                    templateUrl: views + "postulante/documentacionPostulante.html",
                    access: {
                        permissions: ["Incorporaciones.PostulanteConsulta"]
                    }
                })

            .when("/logout",
                {
                    controller: "logoutController",
                    controllerAs: "logoutCtrl",
                    templateUrl: views + "logout/logout.html"
                })
            .when("/admin",
                {
                    controller: "adminController",
                    controllerAs: "adminCtrl",
                    templateUrl: views + "admin/admin.html",
                    access: {
                        permissions: ["Incorporaciones.Admin"]
                    }
                })
            .when("/resetDatosPostulante",
                {
                    controller: "resetDatosPostulanteController",
                    controllerAs: "resetDatosPostulanteCtrl",
                    templateUrl: views + "admin/resetDatosPostulante.html",
                    access: {
                        permissions: ["Incorporaciones.PostulanteConsulta"]
                    }
                })
            .when("/notauthorized", {
                templateUrl: "./notAuthorized.html"
            })
            .when("/notFound", {
                templateUrl: "./notFound.html"
            })
            .otherwise({
                redirectTo: "/notFound"
            });
    });