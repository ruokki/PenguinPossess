<form name="admin" method="POST" action="">
    <table>
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Rôle</th>
                <th>Actif</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user) : ?>
            <tr>
                <td><?php echo $user['user_name']; ?></td>
                <td>
                    <select id="roleUser" name="admin[<?php echo $user['user_id']; ?>][role_id]">
                        <?php foreach($roles as $role) : ?>
                        <option value="<?php echo $role['role_id'] ?>" <?php echo $role['role_id'] === $user['role_id'] ? 'selected="selected"' : ''; ?>>
                            <?php echo $role['role_name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="checkbox" name="admin[<?php echo $user['user_id']; ?>][user_active]" <?php echo intval($user['user_active']) === 1 ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>
            <?php endforeach; ?>        
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <button type="submit">Valider</button>
                </td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</form>