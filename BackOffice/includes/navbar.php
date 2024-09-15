<nav class="navbar-top">
        <div class="nav-wrapper">
            <!-- Sidebar toggle -->
            <a href="#" class="yay-toggle">
                <div class="burg1"></div>
                <div class="burg2"></div>
                <div class="burg3"></div>
            </a>
            <!-- Sidebar toggle -->
            <!-- Logo -->
            <a  href="dashboard.php"
                style="padding:0 !important" 
                class="brand-logo"><img src="images/logos/LogoBB_03.png" alt="Con">
            </a>
            <!-- /Logo -->
            <!-- Menu -->
            <ul>
                <!-- <li><a href="#!" class="search-bar-toggle"><i class="mdi-action-search"></i></a>
                </li> -->
                <!-- <li><a class="dropdown-button" data-activates="test-dropdown" href="#!"><i class="mdi-communication-email"></i> <span class="badge new">2</span></a>
                    <div id="test-dropdown" class="dropdown-content dropdown-media">
                        <div class="card-panel">
                            <div class="media-heading">Messages <a href="mail-compose.html"><i class="mdi-content-add-circle-outline"></i></a>
                            </div>
                            <div class="media-footer"><a href="mail-inbox.html"><i class="mdi-hardware-keyboard-control"></i></a>
                            </div>
                            <div class="row mt-0">
                                <div class="col s2"><img src="assets/_con/images/user2.jpg" alt="" class="circle responsive-img">
                                </div>
                                <div class="col s10"><span class="media-date">9:02 AM</span> <a href="#" class="media-title">Dianne Chambers</a> <span>Ut feugiat tempus felis, sit amet mattis dolor accumsan quis...</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s2"><img src="assets/_con/images/user3.jpg" alt="" class="circle responsive-img">
                                </div>
                                <div class="col s10"><span class="media-date">Dec 19</span> <a href="#" class="media-title">Joanne Stephens</a> <span>Proin suscipit lobortis porta. Interdum et malesuada fames ac ante ipsum primis in faucibus...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li> -->
                <li class="user">
                    <a class="dropdown-button" data-activates="user-dropdown" href="#!">
                        <img src="_recursos/images/<?php echo $_SESSION["admin"]["foto"] ?>" alt="John Doe" class="circle"> <?php echo $_SESSION["admin"]["nombre"] ?> <i class="mdi-navigation-expand-more right"></i>
                    </a>
                    <ul id="user-dropdown" class="dropdown-content">
                        <li><a href="page-profile.html"><i class="fa fa-user"></i> Profile</a>
                        </li>
                        <li><a href="mail-inbox.html"><i class="fa fa-envelope"></i> Messages <span class="badge new">2 new</span></a>
                        </li>
                        <li><a href="#!"><i class="fa fa-cogs"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- /Menu -->
        </div>
    </nav>