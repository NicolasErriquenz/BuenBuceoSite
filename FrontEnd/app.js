(function (angular) {
    //Default environment variables
    var __env = {};
    if (window) { //Importa las variables si existen
        Object.assign(__env, window.__env);
    }
    var app = angular
        .module("angularApp",
            [
                "ngRoute", "ngResource", "app.auth", "cgBusy", 'datatables', 'angularTrix','ngMap', 'dx',
                "ngSanitize", "ngFileUpload", "ui.bootstrap", 'ui.bootstrap.datetimepicker', 'chart.js'
            ])
            .constant("urls",
            __env);

    app.constant('_START_REQUEST_', '_START_REQUEST_');
    app.constant('_END_REQUEST_', '_END_REQUEST_');

    angular
        .module("angularApp")
        .factory("errorHandler",
            [
                "$q", "$rootScope", function ($q, $rootScope) {
                    var interceptor = {
                        responseError: function (response) {
                            if (response.status === 500) {
                                $rootScope.$broadcast("serverError.500", response);
                            }
                            return $q.reject(response);
                        }
                    };
                    return interceptor;
                }
            ])
        .constant("appConfig", __env)
        .config([
            "ngOidcClientProvider", "appConfig", function (ngOidcClientProvider, appConfig) {
                ngOidcClientProvider.setSettings({
                    authority: appConfig.authority,
                    client_id: appConfig.client_id,
                    redirect_uri: appConfig.redirect_uri,
                    silent_redirect_uri: appConfig.silent_redirect_uri,
                    post_logout_redirect_uri: appConfig.post_logout_redirect_uri,
                    response_type: "id_token token",
                    scope: appConfig.scopes,
                    automaticSilentRenew: true,
                    filterProtocolClaims: true,
                    silentRequestTimeout: 30000,
                    userStore: new Oidc.WebStorageStateStore({ store: window.localStorage })
                });
            }
        ])
        .config([
            '$httpProvider', '_START_REQUEST_', '_END_REQUEST_',
            function ($httpProvider, _START_REQUEST_, _END_REQUEST_) {
                //initialize get if not there
                if (!$httpProvider.defaults.headers.get) {
                    $httpProvider.defaults.headers.get = {};
                }
                $httpProvider.defaults.headers.get["Cache-Control"] = "no-cache";
                $httpProvider.defaults.headers.get["Pragma"] = "no-cache";

                $httpProvider.interceptors.push("errorHandler");

                //$httpProvider.interceptors.push(function ($q, $rootScope) {
                //    if ($rootScope.activeCalls == undefined) {
                //        $rootScope.activeCalls = 0;
                //    }

                //    return {
                //        request: function (config) {
                //            $rootScope.activeCalls += 1;
                //            $rootScope.$broadcast(_START_REQUEST_);
                //            return config;
                //        },
                //        requestError: function (rejection) {
                //            $rootScope.activeCalls -= 1;
                //            if ($rootScope.activeCalls === 0)
                //                $rootScope.$broadcast(_END_REQUEST_);
                //            return rejection;
                //        },
                //        response: function (response) {
                //            $rootScope.activeCalls -= 1;
                //            if ($rootScope.activeCalls === 0)
                //                $rootScope.$broadcast(_END_REQUEST_);
                //            return response;
                //        },
                //        responseError: function (rejection) {
                //            $rootScope.activeCalls -= 1;
                //            if ($rootScope.activeCalls === 0)
                //                $rootScope.$broadcast(_END_REQUEST_);
                //            return rejection;
                //        }
                //    };
                //});
            }
        ]);


    app.directive('tooltip', function () {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                element.hover(function () {
                    // on mouseenter
                    element.tooltip('show');
                }, function () {
                    // on mouseleave
                    element.tooltip('hide');
                });
            }
        };
    });

})(angular);
