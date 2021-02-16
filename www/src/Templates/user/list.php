<div class="users-list">
    <?php if (isset($data['error']) && $data['error'] == 'sameUser') { ?>
        <div class="error">
            <span>Cannot visit current user</span>
        </div>
    <?php } ?>
    <div class="actions">
        <div>
            <a href="?controller=user&action=create">Add user</a>
        </div>
        <div>
            <button class="remove-users" onclick="removeSelectedUsers()">Remove selected</button>
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th></th>
            <th>name</th>
            <th>email</th>
            <th>actions</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($data['users'] as $user) {
            echo "<tr>";

            echo "<td>";
            if ($user->getId() !== $_SESSION['user']->getId()) {
                echo "<input data-user='{ \"id\": {$user->getId()}, \"name\": \"{$user->getName()}\" }' type='checkbox' name='users[]'>";
            }
            echo "</td>";

            echo "<td>";
            echo "<a href='?controller=user&action=show&userId={$user->getId()}'>{$user->getName()}</a>";
            echo "</td>";

            echo "<td>";
            echo $user->getEmail();
            echo "</td>";

            echo "<td class=''>";
            if ($user->getId() !== $_SESSION['user']->getId()) {
                echo "<button type='button' onclick='removeUsers([{ id: {$user->getId()}, name: \"{$user->getName()}\" }])'>Delete</button>";
            }
            echo "</td>";

            echo "</tr>";
        }
        ?>
        <tr></tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4">
                <div class="pager">
                    <?php if (!empty($data['pager']['first']) && $data['pager']['currentPage'] !== 1) { ?>
                        <a href="<?= $data['pager']['first']['url'] ?>" class="page-link-first"><</a>
                    <? } ?>
                    <?php foreach($data['pager']['pages'] as $page) { ?>
                        <a
                                href="<?= $page['url'] ?>"
                                class="page-link-number<?= $page['active'] ? ' active' : '' ?>"
                        >
                            <?= $page['number'] ?>
                        </a>
                    <?php } ?>
                    <?php if (!empty($data['pager']['last']) && $data['pager']['currentPage'] !== $data['pager']['last']['number']) { ?>
                    <a href="<?= $data['pager']['last']['url'] ?>" class="page-link-last">></a>
                    <? } ?>
                </div>
            </td>
        </tr>
        </tfoot>
    </table>
</div>