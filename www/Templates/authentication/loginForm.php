<div id="login-page">
    <h2>Wellcome</h2>

    <?php
    if ($data['error']) {
    ?>
        <div class="error">
            <p>Login error</p>
        </div>
    <?php
    }
    ?>

    <form action="" method="post" id="login">
        <input id="email" type="text" name="email" placeholder="Email">
        <input id="password" type="password" name="password" placeholder="Password">

        <button type="submit">Login</button>
    </form>
</div>