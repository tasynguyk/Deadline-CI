<div style="margin-top: 15px;">
    <table>
        <b>Edit or delete user</b><br/>
        <?php 
            echo validation_errors();
            if(isset($error))
                echo $error;
        ?>
        <form action="<?php echo base_url().'index.php/log/log/xulyuser'; ?>" method="post">
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" value="<?php if(isset($username)) echo $username; ?>" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email" value="<?php if(isset($email)) echo $email; ?>"/></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="delete" value="Delete user" /></td>
            </tr>
        </form>
    </table>
</div>