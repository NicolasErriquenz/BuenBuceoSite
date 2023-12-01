angular
    .module("angularApp")
    .controller("appController", ["homeService", "$location", "$rootScope", "$scope", "ngOidcClient", "urls", "$timeout", controladorPrincipal]);

function controladorPrincipal(homeService, $location, $rootScope, $scope, ngOidcClient, urls, $timeout) {
    var vm = this;

    //$(document).ready(function () {
    //    console.log("Ejecuta cuando carga sitio");
    //    $('.maximized-card').remove();
    //    $('body').removeClass('modal-open');
    //    $('.modal-backdrop').remove();
    //});

    vm.MostrarMenu = true;
    vm.openMenu = false;

    vm.abrirMenu = function () {
        //$mdSidenav("left").toggle();
    };

    vm.seleccionarRuta = function (ruta, elem) {
        
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        $location.url(ruta);
    };

    vm.gotoPdt = function () {
        window.open(urls.rutaPdt, "_blank");
    };
    vm.gotoPdt2 = function () {
        window.open(urls.rutaPdt2, "_blank");
    };

    ngOidcClient.getUser();

    

    $scope.$on("ng-oidc-client.userInfoChanged", function () { console.log("ng-oidc-client.userInfoChanged"); });
    $scope.$on("ng-oidc-client.userLoaded", function (e, u) { console.log("ng-oidc-client.userLoaded"); console.log(u); });
    $scope.$on("ng-oidc-client.userUnloaded", function () { console.log("ng-oidc-client.userUnloaded"); });
    $scope.$on("ng-oidc-client.accessTokenExpiring", function () { console.log("ng-oidc-client.accessTokenExpiring"); });
    $scope.$on("ng-oidc-client.accessTokenExpired", function () { console.log("ng-oidc-client.accessTokenExpired"); });
    $scope.$on("ng-oidc-client.silentRenewError", function (e, x) { console.log("ng-oidc-client.silentRenewError"); console.log(x); });
    $scope.$on("ng-oidc-client.userSignedOut", function (e, x) { console.log("ng-oidc-client.userSignedOut"); console.log(x); });
    $scope.$on("ng-oidc-client.userSessionChanged", function (e, x) { console.log("ng-oidc-client.userSessionChanged"); console.log(x); });

    vm.checkPermiso = function (permiso) {
        return vm.user().data ? vm.user().data.profile.role.includes(permiso) : false;
    };

    vm.user = function () {
        return ngOidcClient.getUserInfo();
    };

    //console.log(vm.user());

    vm.openMenu = function ($mdOpenMenu, ev) {
        $mdOpenMenu(ev);
    };

    $scope.$on("ng-oidc-client.accessTokenExpired", function () {
        vm.showDialog('Su sesión expiró. Por favor vuelva a loguearse en la plataforma con sus credenciales');
    });

    vm.login = function () {
        ngOidcClient.manager.signinRedirect();
    };
    vm.logout = function () {
        ngOidcClient.manager.signoutRedirect();
    };

    $rootScope.$on("_START_REQUEST_",
        function () {
            // got the request start notification, show the element
            //if ($rootScope.activeCalls === 1) {
            //    vm.showDialog("Cargando");
                //console.log("COMIENZO", $rootScope.activeCalls);
            //}
        });

    $rootScope.$on("_END_REQUEST_",
        function () {
            // got the request end notification, hide the element
            //element.hide();
            //if ($rootScope.activeCalls == 0) {
            //    vm.closeDialog();
                //console.log("FIN", $rootScope.activeCalls);
            //}

        });

    var errorData = "";

    $rootScope.$on("serverError.500", function (event, errorResponse) {
        errorData = errorResponse.data;
        $("#errorDlg").modal("show");
    });

    $rootScope.$on("serverError.401", function (event, errorResponse) {
        //unauthorized
        errorData = "No tiene permisos para realizar esta acción.";
        $("#errorDlg").modal("show");
    });

    $rootScope.$on("serverError.400", function (event, errorResponse) {
        //bad request
        console.log(errorResponse.data);
        errorData = errorResponse.data;
        vm.showDialog(errorData);
    });

    vm.tituloDialog = "CONTACTO";
    vm.consulta = {
        Motivo: "Contacto"
    };

    vm.abrirContacto = function () {

        vm.consulta.Credencial = vm.user().data.profile.credencial;
        vm.consulta.Givenname = vm.user().data.profile.givenname;

        $mdDialog.show({
            contentElement: '#contactoDialog',
            parent: angular.element(document.body),
            escapeToClose: true,
            clickOutsideToClose: true
        });
    };

    vm.apiKey = urls.recaptcha_key;

    vm.setResponse = function (response) {
        console.info('Response available', response);
        vm.consulta.response = response;
    };

    vm.setWidgetId = function (widgetId) {
        console.info('Created widget ID: %s', widgetId);
        vm.consulta.widgetId = widgetId;
    };

    vm.cbExpiration = function () {
        console.info('Captcha expired. Resetting response object');
        vcRecaptchaService.reload($scope.widgetId);
        vm.consulta.response = null;
    };

    vm.showDialog = function (m) {
        vm.infodlgText = m;
        $("#infoDlg").modal("show");
    };

    vm.GetFechaActual = function () {
        const tiempoTranscurrido = Date.now();
        const hoy = new Date(tiempoTranscurrido);

        formato = "dd/mm/yyyy";

        const map = {
            dd: hoy.getDate(),
            mm: hoy.getMonth() + 1 < 10 ? "0" + (hoy.getMonth() + 1) : hoy.getMonth() + 1,
            yyyy: hoy.getFullYear()
        }
        return formato.replace(/dd|mm|yyyy/gi, matched => map[matched])
    }



    vm.checkKey = function ($event) {
        $event.keyCode == 13 ? vm.buscarAgente() : null;
    };
}



