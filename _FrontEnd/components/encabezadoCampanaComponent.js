angular.module("angularApp").component("encabezadoCampana",
    {
        templateUrl: "components/templates/encabezadoCampana.html",
        controller: "encabezadoCampanaComponentController",
        controllerAs: "encabezadoCampanaCtrl",
        bindings: {
            campana: "<",
            seccion: "="
        }
    });