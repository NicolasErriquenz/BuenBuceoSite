<aside class="yaybar yay-shrink yay-hide-to-small yay-gestures">
        <div class="top">
            <div>
                <!-- Sidebar toggle -->
                <a href="#" class="yay-toggle">
                    <div class="burg1"></div>
                    <div class="burg2"></div>
                    <div class="burg3"></div>
                </a>
                <!-- Sidebar toggle -->
                <!-- Logo -->
                <a href="#!" class="brand-logo"><img src="assets/_con/images/logo-white.png" alt="Con">
                </a>
                <!-- /Logo -->
            </div>
        </div>
        <div class="nano">
            <div class="nano-content">
                <ul>
                    <li class="yay-user-info">
                        <a href="page-profile.html"><img src="_recursos/images/<?php echo $_SESSION["admin"]["foto"] ?>" alt="<?php echo $_SESSION["admin"]["nombre"] ?>" class="circle">
                            <h3 class="yay-user-info-name"><?php echo $_SESSION["admin"]["nombre"] ?></h3>
                            <div class="yay-user-location"><i class="fa fa-gear"></i> Administrador</div>
                        </a>
                    </li>
                    <li class="label">Info estática</li>
                    <li><a href="pagos_rubros.php" class="waves-effect waves-blue"><i class="fa fa-edit"></i> Rubros de pago</a></li>
                    <li><a href="pagos_subrubros.php" class="waves-effect waves-blue"><i class="fa fa-edit"></i> Subrubros de pago</a></li>
                    <li><a href="deudaTipo_listado.php" class="waves-effect waves-blue"><i class="fa fa-edit"></i> Tipo deuda <!--<span class="badge new">new</span>--></a></li>

                    <li class="label">PRINCIPAL</li>
                    <li><a href="#" class="yay-sub-toggle waves-effect waves-blue"><i class="fa fa-users"></i> Usuarios <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="usuarios.php" class="waves-effect waves-blue"><i class="fa fa-bars"></i> Listado</a></li>
                            <li><a href="usuarios_alta.php" class="waves-effect waves-blue"><i class="fa fa-plus"></i> Alta </a></li>
                        </ul>
                    </li>
                    <li><a href="ui-buttons.html" class="yay-sub-toggle waves-effect waves-blue"><i class="fa fa-credit-card"></i> Pagos <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="pagos.php" class="waves-effect waves-blue"><i class="fa fa-bars"></i> Listado </a></li>
                            <li><a href="pagos_alta.php" class="waves-effect waves-blue"><i class="fa fa-plus"></i> Alta </a></li>
                        </ul>
                    </li>
                    <li><a href="media-hover-effects.html" class="yay-sub-toggle waves-effect waves-blue"><i class="mdi mdi-image-panorama"></i> Media <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="media-hover-effects.html" class="waves-effect waves-blue"><i class="mdi mdi-image-style"></i> Hover Effects</a>
                            </li>
                            <li><a href="media-scroll-effects.html" class="waves-effect waves-blue"><i class="fa fa-magic"></i> Scroll Effects</a>
                            </li>
                            <li><a href="media-gallery.html" class="waves-effect waves-blue"><i class="mdi mdi-image-collections"></i> Gallery</a>
                            </li>
                            <li><a href="media-material-box.html" class="waves-effect waves-blue"><i class="mdi mdi-image-collections"></i> Material Box</a>
                            </li>
                            <li><a href="media-parallax.html" class="waves-effect waves-blue"><i class="mdi mdi-image-panorama"></i> Parallax</a>
                            </li>
                            <li><a href="media-player.html" class="waves-effect waves-blue"><i class="mdi mdi-av-play-circle-outline"></i> Player</a>
                            </li>
                            <li><a href="media-slider.html" class="waves-effect waves-blue"><i class="mdi mdi-action-view-carousel"></i> Slider</a>
                            </li>
                        </ul>
                    </li>
                    <li class="label">Components</li>
                    <li><a href="forms-base.html" class="yay-sub-toggle waves-effect waves-blue"><i class="fa fa-check-square-o"></i> Forms <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="forms-base.html" class="waves-effect waves-blue"><i class="fa fa-cube"></i> Base</a>
                            </li>
                            <li><a href="forms-advanced.html" class="waves-effect waves-blue"><i class="fa fa-cubes"></i> Advanced</a>
                            </li>
                            <li><a href="forms-validation.html" class="waves-effect waves-blue"><i class="fa fa-check-square-o"></i> Validation</a>
                            </li>
                            <li><a href="forms-editors.html" class="waves-effect waves-blue"><i class="fa fa-edit"></i> Editors</a>
                            </li>
                            <li><a href="forms-checkout.html" class="waves-effect waves-blue">Checkout</a>
                            </li>
                            <li><a href="forms-contacts.html" class="waves-effect waves-blue">Contacts</a>
                            </li>
                            <li><a href="forms-login.html" class="waves-effect waves-blue">Login</a>
                            </li>
                            <li><a href="forms-register.html" class="waves-effect waves-blue">Register</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="page-profile.html" class="yay-sub-toggle waves-effect waves-blue"><i class="fa fa-globe"></i> Pages <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="page-profile.html" class="waves-effect waves-blue">Profile</a>
                            </li>
                            <li><a href="page-timeline.html" class="waves-effect waves-blue">Timeline</a>
                            </li>
                            <li><a href="page-calendar.html" class="waves-effect waves-blue">Calendar</a>
                            </li>
                            <li><a href="page-forgot-password.html" class="waves-effect waves-blue">Forgot Password</a>
                            </li>
                            <li><a href="page-lock.html" class="waves-effect waves-blue">Screen Lock</a>
                            </li>
                            <li><a href="page-sign-in.html" class="waves-effect waves-blue">Sign In</a>
                            </li>
                            <li><a href="page-sign-up.html" class="waves-effect waves-blue">Sign Up</a>
                            </li>
                            <li><a href="page-404.html" class="waves-effect waves-blue">404</a>
                            </li>
                            <li><a href="page-500.html" class="waves-effect waves-blue">500</a>
                            </li>
                            <li><a href="page-blank.html" class="waves-effect waves-blue">Blank</a>
                            </li>
                        </ul>
                    </li>
                    <li class="label">Extra</li>
                    <li><a href="mail-inbox.html" class="yay-sub-toggle waves-effect waves-blue"><i class="fa fa-envelope"></i> Mailbox <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="mail-inbox.html" class="waves-effect waves-blue"><i class="mdi-content-inbox"></i> Inbox</a>
                            </li>
                            <li><a href="mail-compose.html" class="waves-effect waves-blue"><i class="mdi-content-add-circle"></i> Compose</a>
                            </li>
                            <li><a href="mail-view.html" class="waves-effect waves-blue"><i class="mdi-content-drafts"></i> View</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="ecommerce-dashboard.html" class="yay-sub-toggle waves-effect waves-blue"><i class="mdi mdi-action-shopping-cart"></i> eCommerce <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="ecommerce-dashboard.html" class="waves-effect waves-blue"><i class="fa fa-dashboard"></i> Dashboard</a>
                            </li>
                            <li><a href="ecommerce-products.html" class="waves-effect waves-blue"><i class="fa fa-tags"></i> Products</a>
                            </li>
                            <li><a href="ecommerce-product-single.html" class="waves-effect waves-blue"><i class="fa fa-tag"></i> Product Single</a>
                            </li>
                            <li><a href="ecommerce-orders.html" class="waves-effect waves-blue"><i class="fa fa-cart-plus"></i> Orders</a>
                            </li>
                            <li><a href="ecommerce-order-single.html" class="waves-effect waves-blue"><i class="fa fa-cart-plus"></i> Order Single</a>
                            </li>
                            <li><a href="ecommerce-customers.html" class="waves-effect waves-blue"><i class="fa fa-users"></i> Customers</a>
                            </li>
                            <li><a href="ecommerce-settings.html" class="waves-effect waves-blue"><i class="fa fa-cog"></i> Settings</a>
                            </li>
                            <li><a href="ecommerce-invoice.html" class="waves-effect waves-blue"><i class="ion ion-android-list"></i> Invoice</a>
                            </li>
                            <li><a href="ecommerce-pricing-tables.html" class="waves-effect waves-blue"><i class="fa fa-money"></i> Pricing Tables</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="charts-flot.html" class="yay-sub-toggle waves-effect waves-blue"><i class="fa fa-bar-chart"></i> Charts <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="charts-flot.html" class="waves-effect waves-blue">Flot</a>
                            </li>
                            <li><a href="charts-rickshaw.html" class="waves-effect waves-blue">Rickshaw</a>
                            </li>
                            <li><a href="charts-sparkline.html" class="waves-effect waves-blue">Sparkline</a>
                            </li>
                            <li><a href="charts-nvd3.html" class="waves-effect waves-blue">NVD3</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="maps-google.html" class="yay-sub-toggle waves-effect waves-blue"><i class="mdi mdi-maps-place"></i> Maps <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="maps-google.html" class="waves-effect waves-blue">Google Maps</a>
                            </li>
                            <li><a href="maps-vector.html" class="waves-effect waves-blue">Vector Maps</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="ui-tables.html" class="yay-sub-toggle waves-effect waves-blue"><i class="fa fa-table"></i> Tables <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="ui-tables.html" class="waves-effect waves-blue">Base Tables</a>
                            </li>
                            <li><a href="ui-datatables.html" class="waves-effect waves-blue">Data Tables</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#" class="yay-sub-toggle waves-effect waves-blue"><i class="fa fa-indent"></i> Menu Levels <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                        <ul>
                            <li><a href="#" class="yay-sub-toggle waves-effect waves-blue">Second Level <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                                <ul>
                                    <li><a href="#1" class="yay-sub-toggle waves-effect waves-blue">Third Level <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                                        <ul>
                                            <li><a href="#1" class="waves-effect waves-blue">Fourth Level</a>
                                            </li>
                                            <li><a href="#2" class="waves-effect waves-blue">Fourth Level</a>
                                            </li>
                                            <li><a href="#3" class="waves-effect waves-blue">Fourth Level</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="#2" class="yay-sub-toggle waves-effect waves-blue">Third Level <span class="yay-collapse-icon mdi-navigation-expand-more"></span></a>
                                        <ul>
                                            <li><a href="#1" class="waves-effect waves-blue">Fourth Level</a>
                                            </li>
                                            <li><a href="#2" class="waves-effect waves-blue">Fourth Level</a>
                                            </li>
                                            <li><a href="#3" class="waves-effect waves-blue">Fourth Level</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="label">Stats</li>
                    <li class="content"><span><i class="fa fa-spinner"></i> Server Load</span>
                        <div class="progress small light-green lighten-4">
                            <div class="light-green accent-5" style="width: 37%"></div>
                        </div><span><i class="fa fa-thumbs-o-up"></i> User Satisfaction</span>
                        <div class="progress small">
                            <div style="width: 91%"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </aside>