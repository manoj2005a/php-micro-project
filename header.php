<?php
// Check if a session is not already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if(isset($_SESSION['user_id'])) {
    // If logged in, show profile option
    $profile_link = '<a href="profile.php">Profile</a>';
    $login_signup_link = ''; // No need to show login/signup options
} else {
    // If not logged in, show login/signup options
    $profile_link = '';
    $login_signup_link = '<a href="login1.php">Login </a>| <a href="singup.html">Sign Up</a>';
}
?>

<div class="header">
    <div class="logo-container">
    <a href="login.html"> <img src="logo.jpeg" alt="Website Logo" class="logo"></a>
        <h1 class="logo-text">php micro project</h1>
    </div>
    <nav>
        <ul>
            <li class="nav-item"><?php echo $profile_link; ?></li>
            <li class="nav-item"><?php echo $login_signup_link; ?></li>
        </ul>
    </nav>
</div>

<style>
    .header {
        height: 50px;
        background-color: #333;
        color: #fff;
        display: flex;
        justify-content: space-between; /* Changed to space-between to push the nav items to the right */
        align-items: center;
        padding: 0 20px;
    }

    .logo-container {
        display: flex;
        align-items: center;
    }

    .logo {
        width: 30px;
        height: 30px;
        margin-right: 10px;
    }

    .logo-text {
        margin: 0; /* Remove any default margin */
    }

    .nav-item {
        list-style: none; /* Remove default list item style */
    }

    .nav-item a {
        color: #fff;
        text-decoration: none;
        margin-left: 10px; /* Apply margin to the right of each nav item */
    }
</style>
