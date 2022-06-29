<form method='GET' action=''>
    <input type='file' name='fichier'>
    <?php
    print_r($_FILES);
    if(isset($_FILES)){
        echo '<img src="';
    }
    ?>
</form>