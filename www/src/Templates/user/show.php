<div class="user-data">

    <div class="actions">
        <div>
            <a href="?controller=user&action=list">Go back to users list</a>
        </div>
    </div>

    <?php if (isset($data['createError']) && !empty($data['createError'])) { ?>
        <div class="error">
            <p>Error creating user</p>
        </div>
    <?php } ?>

    <form class="user-form" name="user-<?= $data['formMode'] ?? 'edit' ?>" method="post" onsubmit="return checkPasswordsEqual(this)">
        <div class="data-container">
            <input placeholder="Name" id="name" type="text" name="name" required
                   value="<?= isset($data['user']) && $data['user'] instanceof \Model\User ? $data['user']->getName() : '' ?>">
            <input placeholder="Email" id="email" type="text" name="email" required
                   value="<?= isset($data['user']) && $data['user'] instanceof \Model\User ? $data['user']->getEmail() : '' ?>">
        </div>

        <div class="data-container">
            <input placeholder="Password" id="password" type="password" name="password">
            <input placeholder="Repeat password" id="repeat_password" type="password" name="repeat_password">
        </div>

        <div class="actions">
            <div>
                <input type="submit" value="Save">
            </div>
            <?php
            if ((isset($data['formMode']) && in_array($data['formMode'], ['create', 'edit'])) && isset($data['user']) && $data['user'] instanceof \Model\User) {
                ?>
                <div>
                    <button id="remove-user" data-user-name="<?= $data['user']->getName() ?>" data-user-id="<?= $data['user']->getId() ?>" type="button">Remove user</button>
                </div>
                <?php
            }
            ?>
        </div>

        <input type="hidden" name="formMode" value="<?= $data['formMode'] ?? 'edit' ?>">
    </form>
</div>