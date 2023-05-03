<?php
    if(!defined('Include')) {
        die('Direct access not permitted');
    }


?>

<nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="index.php"><img src="assets/images/logo.svg" alt="logo" /></a>
                <a class="sidebar-brand brand-logo-mini" href="index.php"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
            </div>
            <ul class="nav">
                <li class="nav-item nav-category">
                    <span class="nav-link">Navigation</span>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="dashboard.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-speedometer"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ads" aria-expanded="false" aria-controls="ads">
                        <span class="menu-icon">
                            <i class="mdi mdi-cash"></i>
                        </span>
                        <span class="menu-title">Ad Spots</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ads">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="ads.php">Ad Spots List</a></li>
                            <li class="nav-item"> <a class="nav-link" href="createad.php">Create new Ad Spot</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#users" aria-expanded="false" aria-controls="users">
                        <span class="menu-icon">
                            <i class="mdi mdi-account"></i>
                        </span>
                        <span class="menu-title">Users</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="users">
                        <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="reguserlist.php">User List</a></li>
                            <li class="nav-item"> <a class="nav-link" href="userlist.php">Admin User List</a></li>
                            <li class="nav-item"> <a class="nav-link" href="createuser.php">Create new Admin User</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#usergroup" aria-expanded="false" aria-controls="usergroup">
                        <span class="menu-icon">
                            <i class="mdi mdi-account"></i>
                        </span>
                        <span class="menu-title">User Groups</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="usergroup">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="usergrouplist.php">User Group List</a></li>
                            <li class="nav-item"> <a class="nav-link" href="createusergroup.php">Create new User Group</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="settings.php">
                        <span class="menu-icon">
                            <i class="mdi mdi-settings"></i>
                        </span>
                        <span class="menu-title">Settings</span>
                    </a>
                </li>
            </ul>
        </nav>