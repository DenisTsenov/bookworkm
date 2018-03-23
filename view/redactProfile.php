<div class="baic_content">
    <form action="./controller/usersController.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>
                    First name:
                </td>
                <td>
                    <input type="text" name="first_name" value="<?= $_SESSION["user"]["first_name"] ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Last name:
                </td>
                <td>
                    <input type="text" name="last_name" value="<?= $_SESSION["user"]["last_name"] ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Email:
                </td>
                <td>
                    <input type="email" name="email" value="<?= $_SESSION["user"]["email"] ?>">
                </td>
            </tr>
            <tr>
                <td>
                    Old Password:
                </td>
                <td>
                    <input type="password" name="old_pass">
                </td>
            </tr>
            <tr>
                <td>
                    New password:
                </td>
                <td>
                    <input type="password" name="new_pass">
                </td>
            </tr>
            <tr>
                <td>
                    Your avatar:
                </td>
                <td>
                    <img src="<?= $_SESSION["user"]["img_name"] ?>" alt="">
                </td>
            </tr>
            <tr>
                <td>
                    Upload new:
                </td>
                <td>
                    <input type="file" name="avatar">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="edit_profile" value="Edit">
                </td>
            </tr>
        </table>
    </form>
</div>

