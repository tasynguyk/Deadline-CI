<div style="margin-top: 15px;">
    <table>
        <b>Create user</b><br/>
        <?php 
            echo validation_errors();
            if(isset($error))
                echo $error;
        ?>
        <form action="" method="post">
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" name="email" /></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="create" value="Create user" /></td>
            </tr>
        </form>
    </table>
</div>