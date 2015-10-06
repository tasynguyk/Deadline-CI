<b>Manage user</b><br/>
<table>
    <tr>
        <td>
            Username
        </td>
        <td>
            Email
        </td>
        <td></td>
    </tr>
    <?php
        foreach ($list as $key => $val) {
            ?>
            <tr>
                <td>
                    <?php echo $val['username']; ?>
                </td>
                <td>
                    <?php echo $val['email']; ?>
                </td>
                <td><a href="<?php echo base_url().'index.php/log/log/eod/'.$val['id']; ?>">Delete or edit</a></td>
            </tr>
    <?php
        }
    ?>
</table>