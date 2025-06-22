var enums = {
    authorised: {
        authorised: 0,
        loginRequired: 1,
        notAuthorised: 2
    },
    permissionCheckType: {
        atLeastOne: 0,
        combinationRequired: 1
    }
};

var events = {
    userLoggedIn: "auth:user:loggedIn",
    userLoggedOut: "auth:user:loggedOut"
};

var NgOidcClientProvider = (function () {
    function NgOidcClientProvider() {
        this.settings = null;
        this.mgr = null;
        this.userInfo = {
            data: null,
            isAuthenticated: false
        };
        this.urls = [];
        this.$get.$inject = ["$q", "$rootScope"];
    }
    NgOidcClientProvider.prototype.setSettings = function (options) {
        this.settings = options;
    };
    NgOidcClientProvider.prototype.setUrls = function (options) {
        this.urls = options;
    };
    NgOidcClientProvider.prototype.$get = function ($q, $rootScope) {
        var _this = this;
        //$log.log("NgOidcClient service started");
        if (!this.settings)
            throw Error("NgOidcUserService: Must call setSettings() with the required options.");
        //Oidc.Log.logger = console;
        //Oidc.Log.logLevel = Oidc.Log.INFO;
        this.mgr = new Oidc.UserManager(this.settings);
        var notifyUserInfoChangedEvent = function () {
            $rootScope.$broadcast("ng-oidc-client.userInfoChanged");
        };
        this.mgr.events.addUserLoaded(function (u) {
            _this.userInfo.data = u;
            _this.userInfo.isAuthenticated = true;
            $rootScope.$broadcast("ng-oidc-client.userLoaded", u);
            notifyUserInfoChangedEvent();
        });
        this.mgr.events.addUserUnloaded(function () {
            _this.userInfo.data = null;
            _this.userInfo.isAuthenticated = false;
            $rootScope.$broadcast("ng-oidc-client.userUnloaded");
            notifyUserInfoChangedEvent();
        });
        this.mgr.events.addAccessTokenExpiring(function () {
            $rootScope.$broadcast("ng-oidc-client.accessTokenExpiring");
        });
        this.mgr.events.addAccessTokenExpired(function () {
            _this.userInfo.data = null;
            _this.userInfo.isAuthenticated = false;
            $rootScope.$broadcast("ng-oidc-client.accessTokenExpired");
            notifyUserInfoChangedEvent();
        });
        this.mgr.events.addSilentRenewError(function (e) {
            _this.userInfo.data = null;
            _this.userInfo.isAuthenticated = false;
            $rootScope.$broadcast("ng-oidc-client.silentRenewError", e);
            notifyUserInfoChangedEvent();
        });
        this.mgr.events.addUserSignedOut(function (e) {
            // TODO VER NICO
            return;
            _this.userInfo.data = null;
            _this.userInfo.isAuthenticated = false;
            $rootScope.$broadcast("ng-oidc-client.userSignedOut", e);
            notifyUserInfoChangedEvent();
        });
        this.mgr.events.addUserSessionChanged(function (e) {
            $rootScope.$broadcast("ng-oidc-client.userSessionChanged", e);
            notifyUserInfoChangedEvent();
        });
        var signinPopup = function (args) {
            return _this.mgr.signinPopup(args);
        };
        var signinRedirect = function (args) {
            return _this.mgr.signinRedirect(args);
        };
        var signoutPopup = function (args) {
            return _this.mgr.signoutPopup(args);
        };
        var signoutRedirect = function (args) {
            return _this.mgr.signoutRedirect(args);
        };
        var getUrls = function () {
            return _this.urls;
        };
        var getUser = function () {
            return _this.mgr.getUser().then(function (user) {
                _this.userInfo = {
                    data: user,
                    isAuthenticated: !!user
                };
                return _this.userInfo;
            });
        }
        var getUserInfo = function () {
            return _this.userInfo;
        };
        var userInfoChanged = function (scope, callback) {
            var handler = $rootScope.$on("ng-oidc-client.userInfoChanged", callback);
            scope.$on("$destroy", handler);
        };
        return {
            manager: _this.mgr,
            getUser: getUser,
            getUserInfo: getUserInfo,
            getUrls: getUrls,
            signinPopup: signinPopup,
            signinRedirect: signinRedirect,
            signoutPopup: signoutPopup,
            signoutRedirect: signoutRedirect,
            userInfoChanged: userInfoChanged
        };
    };
    return NgOidcClientProvider;
}());

angular
    .module("app.auth", [])
    .provider("ngOidcClient", NgOidcClientProvider)
    .factory("authorization", ["ngOidcClient",
        function (ngOidcClient) {
            var authorize = function (allowAnonymous, requiredPermissions, permissionCheckType) {
                return ngOidcClient.getUser().then(processAuthorize);

                function processAuthorize(user) {
                    var result = enums.authorised.authorised,
                        loweredPermissions = [],
                        hasPermission = true,
                        permission,
                        i;

                    permissionCheckType = permissionCheckType || enums.permissionCheckType.atLeastOne;
                    if (allowAnonymous !== true && (user === undefined || user === null || !user.isAuthenticated)) {
                        result = enums.authorised.loginRequired;
                    } else if ((allowAnonymous !== true && user !== undefined && user !== null) &&
                        (requiredPermissions === undefined || requiredPermissions.length === 0)) {
                        // Login is required but no specific permissions are specified.
                        result = enums.authorised.authorised;
                    } else if (requiredPermissions) {

                        loweredPermissions = [];
                        angular.forEach(user.data.profile.role, function (role) {
                            loweredPermissions.push(role.toLowerCase());
                        });

                        for (i = 0; i < requiredPermissions.length; i += 1) {
                            permission = requiredPermissions[i].toLowerCase();
                            if (permissionCheckType === enums.permissionCheckType.combinationRequired) {
                                hasPermission = hasPermission && loweredPermissions.indexOf(permission) > -1;
                                // if all the permissions are required and hasPermission is false there is no point carrying on
                                if (hasPermission === false) {
                                    break;
                                }
                            } else if (permissionCheckType === enums.permissionCheckType.atLeastOne) {
                                hasPermission = loweredPermissions.indexOf(permission) > -1;
                                // if we only need one of the permissions and we have it there is no point carrying on
                                if (hasPermission) {
                                    break;
                                }
                            }
                        }
                        result = hasPermission ? enums.authorised.authorised : enums.authorised.notAuthorised;
                    }
                    return result;
                }
            };

            return {
                authorize: authorize
            };
        }
    ])
    .directive("access", ["authorization",
        function (authorization) {
            return {
                restrict: "A",
                link: function (scope, element, attrs) {
                    var makeVisible = function () {
                        element.removeClass("hidden");
                    },
                        makeHidden = function () {
                            element.addClass("hidden");
                        },
                        role = attrs.access.split(","),
                        determineVisibility = function (resetFirst) {
                            if (resetFirst) {
                                makeVisible();
                            }

                            authorization.authorize(false, role, attrs.accessPermissionType)
                                .then(function (result) {
                                    if (result === enums.authorised.authorised) {
                                        makeVisible();
                                    } else {
                                        makeHidden();
                                    }
                                });
                            //var result = authorization.authorize(false, role, attrs.accessPermissionType);
                        };

                    if (role.length > 0) {
                        determineVisibility(true);
                    }
                }
            };
        }
    ])
    .factory("authInterceptor", ["$q", "ngOidcClient",
        function ($q, ngOidcClient) {
            var interceptor = {
                request: function (config) {
                    var user = ngOidcClient.getUserInfo();
                    if (user.isAuthenticated) {
                        config.headers["Authorization"] = "Bearer " + user.data.access_token;
                    }
                    return config;
                },
                response: function (response) {
                    return response || $q.when(response);
                },
                responseError: function (response) {
                    if (response.status === 403) {
                        alert("La solicitud al servidor fue rechazada por no tener permisos suficientes para completarla.");
                    }
                    return $q.reject(response);
                }
            }

            return interceptor;
        }])
    .config(["$httpProvider", function ($httpProvider) {
        $httpProvider.interceptors.push("authInterceptor");
    }])
    .run(["$rootScope", "$location", "authorization", function ($rootScope, $location, authorization) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            var authorized;

            if (next.access !== undefined) {
                authorization.authorize(next.access.allowAnonymous,
                    next.access.permissions,
                    next.access.permissionCheckType).then(function (response) {
                        authorized = response;
                        if (authorized === enums.authorised.notAuthorised) {
                            $location.path("/notauthorized").replace();
                        } else if (authorized === enums.authorised.loginRequired) {
                            $location.path("/").replace();
                        }
                    });

            }
        });
    }]);
