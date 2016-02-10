<?php
	if(! isset($_SESSION['code'])) {

		exit("Direct Script Not Allowed!");

	}

/*
* This is a navigation bar to in admin menu nav bar
*
*/

?>	

	<!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<a class="navbar-brand" href="#">Menu</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">
						<strong>Home</strong>
						</a>
                    </li>
					<li>
						<a href="reservations.php"><strong>Schedules and Reservations</strong></a>
					</li>
                    <li>
						<a href="edit_announcement.php"><strong>Edit Announcement</strong></a>
                    </li>
                    </li>
                    <li>
                        <a href="chat.php"><strong>Chat</strong></a>
                    </li>
					<li>
						<a href="?s=logout"><strong>Logout</strong></a>
					</li>
				
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	