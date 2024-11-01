
<?php  
    
    require_once ("Connections/ssi_seguridad.php");
    
    require_once ("Connections/config.php");
    require_once ("Connections/connect.php");

?>
<!DOCTYPE html>
<html lang="en">
    
    <?php include("includes/head.php"); ?>

<body>

    <?php include("includes/navbar.php"); ?>

    <?php include("includes/menu.php"); ?>

    <section class="content-wrap">
        <!-- Breadcrumb -->
        <div class="page-title">
            <div class="row">
                <div class="col s12 m9 l10">
                    <h1>Dashboard v1</h1>
                    <ul>
                        <li><a href="#"><i class="fa fa-home"></i> Home</a> /</li>
                        <li><a href="#">Category</a> /</li>
                        <li><a href="dashboard-v1.html">Dashboard v1</a>
                        </li>
                    </ul>
                </div>
                <div class="col s12 m3 l2 right-align"><a href="#!" class="btn grey lighten-3 grey-text z-depth-0 chat-toggle"><i class="fa fa-comments"></i></a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->
        <!-- Stats Panels -->
        <div class="row sortable">
            <div class="col l3 m6 s12"><a href="#" class="card-panel stats-card red lighten-2 red-text text-lighten-5"><i class="fa fa-comments-o"></i> <span class="count">145</span><div class="name">Feedbacks</div></a>
            </div>
            <div class="col l3 m6 s12"><a href="#" class="card-panel stats-card blue lighten-2 blue-text text-lighten-5"><i class="fa fa-send"></i> <span class="count">342</span><div class="name">Posts</div></a>
            </div>
            <div class="col l3 m6 s12"><a href="#" class="card-panel stats-card amber lighten-2 amber-text text-lighten-5"><i class="fa fa-cloud-upload"></i> <span class="count">58</span><div class="name">Uploads</div></a>
            </div>
            <div class="col l3 m6 s12">
                <div class="card-panel stats-card green lighten-2 green-text text-lighten-5"><i class="fa fa-spinner"></i> <span class="count">37%</span>
                    <div class="name">Server Load</div>
                </div>
            </div>
        </div>
        <!-- /Stats Panels -->
        <div class="row sortable">
            <!-- Weather -->
            <div class="col l4 s12">
                <div class="card-panel weather-card blue-grey lighten-2 white-text">
                    <p class="center"><i class="fa fa-spinner fa-pulse"></i> Weather</p>
                </div>
            </div>
            <!-- /Weather -->
            <!-- Chart with Visits -->
            <div class="col l8 s12">
                <div class="card-panel" id="chart1" style="height: 191px"></div>
            </div>
            <!-- /Chart with Visits -->
        </div>
        <div class="row sortable">
            <!-- Orders Card -->
            <div class="col l4 s12">
                <div class="card">
                    <div class="title">
                        <h5>Orders</h5><a class="close" href="#"><i class="mdi-content-clear"></i></a> <a class="minimize" href="#"><i class="mdi-navigation-expand-less"></i></a>
                    </div>
                    <div class="content orders-card">
                        <h4>3,729</h4>
                        <div class="row">
                            <div class="col s6"><small>Total Orders</small>
                            </div>
                            <div class="col s6 right-align">77% <i class="fa fa-level-down red-text"></i>
                            </div>
                        </div>
                        <div class="progress small">
                            <div class="determinate" style="width: 77%"></div>
                        </div>
                        <h4>$7,180</h4>
                        <div class="row">
                            <div class="col s6"><small>Total Income</small>
                            </div>
                            <div class="col s6 right-align">43% <i class="fa fa-level-up green-text"></i>
                            </div>
                        </div>
                        <div class="progress small">
                            <div class="determinate" style="width: 43%"></div>
                        </div>
                        <h4>27</h4>
                        <div class="row">
                            <div class="col s6"><small>Total Refunds</small>
                            </div>
                            <div class="col s6 right-align">7%</div>
                        </div>
                        <div class="progress small">
                            <div class="determinate" style="width: 7%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Orders Card -->
            <!-- ToDo Card -->
            <div class="col l4 s12">
                <div class="card">
                    <div class="title">
                        <h5>Todo</h5><a class="close" href="#"><i class="mdi-content-clear"></i></a> <a class="minimize" href="#"><i class="mdi-navigation-expand-less"></i></a>
                    </div>
                    <div class="content todo-card">
                        <div class="todo-task">
                            <input type="checkbox" id="checkbox1" checked="checked">
                            <label for="checkbox1">Transfer projects to the Gulp <span class="todo-remove mdi-action-delete"></span>
                            </label>
                        </div>
                        <div class="todo-task">
                            <input type="checkbox" id="checkbox2">
                            <label for="checkbox2">Make video for Youtube <span class="todo-remove mdi-action-delete"></span>
                            </label>
                        </div>
                        <div class="todo-task">
                            <input type="checkbox" id="checkbox4">
                            <label for="checkbox4">Learn Meteor.js <span class="todo-remove mdi-action-delete"></span>
                            </label>
                        </div>
                        <div class="input-field">
                            <input id="todo-add" type="text">
                            <label for="todo-add">Add New</label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /ToDo Card -->
            <!-- Mail Card -->
            <div class="col l4 s12">
                <div class="card">
                    <div class="title">
                        <h5>Mail</h5><a class="close" href="#"><i class="mdi-content-clear"></i></a> <a class="minimize" href="#"><i class="mdi-navigation-expand-less"></i></a>
                    </div>
                    <div class="content mail-card">
                        <div class="row">
                            <div class="col s8"><a href="mail-view.html"><strong>Dianne Chambers</strong></a>
                            </div>
                            <div class="col s4 right-align"><small>9:02 AM</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><a href="mail-view.html">Ut feugiat tempus felis, sit amet mattis dolor accumsan quis. Aenean pharetra tempus justo, vitae euismod ipsum congue a.</a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col s8"><a href="mail-view.html"><strong>Joanne Stephens</strong></a>
                            </div>
                            <div class="col s4 right-align"><small>Dec 19</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><a href="mail-view.html">Proin suscipit lobortis porta. Interdum et malesuada fames ac ante ipsum primis in faucibus.</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Mail Card -->
        </div>
        <div class="row sortable">
            <!-- Stacked Area Chart -->
            <div class="col s12 l7">
                <div class="card">
                    <div class="title">
                        <h5>Stacked Area Chart</h5><a class="close" href="#"><i class="mdi-content-clear"></i></a> <a class="minimize" href="#"><i class="mdi-navigation-expand-less"></i></a>
                    </div>
                    <div class="content">
                        <div id="chart2" style="height: 350px"></div>
                    </div>
                </div>
            </div>
            <!-- /Stacked Area Chart -->
            <!-- Pie Chart -->
            <div class="col s12 l5">
                <div class="card">
                    <div class="title">
                        <h5>Pie Chart</h5><a class="close" href="#"><i class="mdi-content-clear"></i></a> <a class="minimize" href="#"><i class="mdi-navigation-expand-less"></i></a>
                    </div>
                    <div class="content">
                        <div id="chart4" style="height: 350px"></div>
                    </div>
                </div>
            </div>
            <!-- /Pie Chart -->
        </div>
    </section>
    <!-- /Main Content -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="layer-overlay"></div>
        <div class="layer-content">
            <form action="#!">
                <!-- Header --><a class="search-bar-toggle grey-text text-darken-2" href="#!"><i class="mdi-navigation-close"></i></a>
                <!-- Search Input -->
                <div class="input-field"><i class="mdi-action-search prefix"></i>
                    <input type="text" name="con-search" placeholder="Search...">
                </div>
                <!-- Search Results -->
                <div class="search-results">
                    <div class="row">
                        <div class="col s12 l4">
                            <h4>Users</h4>
                            <div class="each-result"><img src="assets/_con/images/user2.jpg" alt="Felecia Castro" class="circle photo">
                                <div class="title">Felecia Castro</div>
                                <div class="label">Content Manager</div>
                            </div>
                            <div class="each-result"><img src="assets/_con/images/user3.jpg" alt="Max Brooks" class="circle photo">
                                <div class="title">Max Brooks</div>
                                <div class="label">Programmer</div>
                            </div>
                            <div class="each-result"><img src="assets/_con/images/user4.jpg" alt="Patsy Griffin" class="circle photo">
                                <div class="title">Patsy Griffin</div>
                                <div class="label">Support</div>
                            </div>
                            <div class="each-result"><img src="assets/_con/images/user6.jpg" alt="Vernon Garrett" class="circle photo">
                                <div class="title">Vernon Garrett</div>
                                <div class="label">Photographer</div>
                            </div>
                        </div>
                        <div class="col s12 l4">
                            <h4>Articles</h4>
                            <div class="each-result">
                                <div class="icon circle blue white-text">MD</div>
                                <div class="title">Material Design</div>
                                <div class="label nowrap">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi consequatur debitis veritatis dolorum, enim libero!</div>
                            </div>
                            <div class="each-result">
                                <div class="icon circle teal white-text"><i class="fa fa-dashboard"></i>
                                </div>
                                <div class="title">Admin Dashboard</div>
                                <div class="label nowrap">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi consequatur debitis veritatis dolorum, enim libero!</div>
                            </div>
                            <div class="each-result">
                                <div class="icon circle orange white-text">RD</div>
                                <div class="title">Responsive Design</div>
                                <div class="label nowrap">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi consequatur debitis veritatis dolorum, enim libero!</div>
                            </div>
                            <div class="each-result">
                                <div class="icon circle red white-text"><i class="fa fa-tablet"></i>
                                </div>
                                <div class="title">Mobile First</div>
                                <div class="label nowrap">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi consequatur debitis veritatis dolorum, enim libero!</div>
                            </div>
                        </div>
                        <div class="col s12 l4">
                            <h4>Posts</h4>
                            <div class="no-result">No results were found ;(</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /Search Bar -->
    <!--
  Chat
    .chat-light - light color scheme
-->
    <div class="chat">
        <div class="layer-overlay"></div>
        <div class="layer-content">
            <!-- Contacts -->
            <div class="contacts">
                <!-- Top Bar -->
                <div class="topbar"><a href="#!" class="text">Chat</a> <a href="#!" class="chat-toggle"><i class="mdi-navigation-close"></i></a>
                </div>
                <!-- /Top Bar -->
                <div class="nano">
                    <div class="nano-content"><span class="label">Online</span>
                        <div class="user"><img src="assets/_con/images/user2.jpg" alt="Felecia Castro" class="circle photo">
                            <div class="name">Felecia Castro</div>
                            <div class="status">Lorem status</div>
                            <div class="online"><i class="green-text fa fa-circle"></i>
                            </div>
                        </div>
                        <div class="user"><img src="assets/_con/images/user3.jpg" alt="Max Brooks" class="circle photo">
                            <div class="name">Max Brooks</div>
                            <div class="status">Lorem status</div>
                            <div class="online"><i class="green-text fa fa-circle"></i>
                            </div>
                        </div>
                        <div class="user"><img src="assets/_con/images/user4.jpg" alt="Patsy Griffin" class="circle photo">
                            <div class="name">Patsy Griffin</div>
                            <div class="status">Lorem status</div>
                            <div class="online"><i class="green-text fa fa-circle"></i>
                            </div>
                        </div>
                        <div class="user"><img src="assets/_con/images/user5.jpg" alt="Chloe Morgan" class="circle photo">
                            <div class="name">Chloe Morgan</div>
                            <div class="status">Lorem status</div>
                            <div class="online"><i class="green-text fa fa-circle"></i>
                            </div>
                        </div>
                        <div class="user"><img src="assets/_con/images/user6.jpg" alt="Vernon Garrett" class="circle photo">
                            <div class="name">Vernon Garrett</div>
                            <div class="status">Lorem status</div>
                            <div class="online"><i class="yellow-text fa fa-circle"></i>
                            </div>
                        </div>
                        <div class="user"><img src="assets/_con/images/user7.jpg" alt="Greg Mcdonalid" class="circle photo">
                            <div class="name">Greg Mcdonalid</div>
                            <div class="status">Lorem status</div>
                            <div class="online"><i class="yellow-text fa fa-circle"></i>
                            </div>
                        </div>
                        <div class="user"><img src="assets/_con/images/user8.jpg" alt="Christian Jackson" class="circle photo">
                            <div class="name">Christian Jackson</div>
                            <div class="status">Lorem status</div>
                            <div class="online"><i class="yellow-text fa fa-circle"></i>
                            </div>
                        </div><span class="label">Offline</span>
                        <div class="user"><img src="assets/_con/images/user9.jpg" alt="Willie Kelly" class="circle photo">
                            <div class="name">Willie Kelly</div>
                            <div class="status">Lorem status</div>
                        </div>
                        <div class="user"><img src="assets/_con/images/user10.jpg" alt="Jenny Phillips" class="circle photo">
                            <div class="name">Jenny Phillips</div>
                            <div class="status">Lorem status</div>
                        </div>
                        <div class="user"><img src="assets/_con/images/user11.jpg" alt="Darren Cunningham" class="circle photo">
                            <div class="name">Darren Cunningham</div>
                            <div class="status">Lorem status</div>
                        </div>
                        <div class="user"><img src="assets/_con/images/user12.jpg" alt="Sandra Cole" class="circle photo">
                            <div class="name">Sandra Cole</div>
                            <div class="status">Lorem status</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Contacts -->
            <!-- Messages -->
            <div class="messages">
                <!-- Top Bar with back link -->
                <div class="topbar"><a href="#!" class="chat-toggle"><i class="mdi-navigation-close"></i></a> <a href="#!" class="chat-back"><i class="mdi-hardware-keyboard-arrow-left"></i> Back</a>
                </div>
                <!-- /Top Bar with back link -->
                <!-- All messages list -->
                <div class="list">
                    <div class="nano scroll-bottom">
                        <div class="nano-content">
                            <div class="date">Monday, Feb 23, 8:23 pm</div>
                            <div class="from-me">Hi, Felicia.
                                <br>How are you?</div>
                            <div class="clear"></div>
                            <div class="from-them"><img src="assets/_con/images/user2.jpg" alt="John Doe" class="circle photo"> Hi! I am good!</div>
                            <div class="clear"></div>
                            <div class="from-me">Glad to see you :)
                                <br>This long text is intended to show how the chat will display it.</div>
                            <div class="clear"></div>
                            <div class="from-them"><img src="assets/_con/images/user2.jpg" alt="John Doe" class="circle photo"> Also, we will send the longest word to show how it will fit in the chat window: <strong>Pneumonoultramicroscopicsilicovolcanoconiosis</strong>
                            </div>
                            <div class="date">Friday, Mar 10, 5:07 pm</div>
                            <div class="from-me">Hi again!</div>
                            <div class="clear"></div>
                            <div class="from-them"><img src="assets/_con/images/user2.jpg" alt="John Doe" class="circle photo"> Hi! Glad to see you.</div>
                            <div class="clear"></div>
                            <div class="from-me">I want to add you in my Facebook.</div>
                            <div class="clear"></div>
                            <div class="from-me">Can you give me your page?</div>
                            <div class="clear"></div>
                            <div class="from-them"><img src="assets/_con/images/user2.jpg" alt="John Doe" class="circle photo"> I do not use Facebook. But you can follow me in Twitter.</div>
                            <div class="clear"></div>
                            <div class="from-me">It's good idea!</div>
                            <div class="clear"></div>
                            <div class="from-them"><img src="assets/_con/images/user2.jpg" alt="John Doe" class="circle photo"> You can find me here - <a href="https://twitter.com/nkdevv">https://twitter.com/nkdevv</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /All messages list -->
                <!-- Send message -->
                <div class="send">
                    <form action="#!">
                        <div class="input-field">
                            <input id="chat-message" type="text" name="chat-message">
                        </div>
                        <button class="btn waves-effect z-depth-0"><i class="mdi-content-send"></i>
                        </button>
                    </form>
                </div>
                <!-- /Send message -->
            </div>
            <!-- /Messages -->
        </div>
    </div>
    
    
</body>

</html>