<h1>My account</h1>
<h2>Welcome <?php echo $this->session->username; ?></h2>
<?php echo anchor('sign-out', 'Sign out'); ?>