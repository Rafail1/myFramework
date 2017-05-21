        </div> <!-- /container -->
        
        <link href="<?=PUBLIC_DIR?>/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?=PUBLIC_DIR?>/css/style.css" rel="stylesheet" type="text/css"/>
        <script src="<?=PUBLIC_DIR?>/js/jquery.js"></script>
        <script src="<?=PUBLIC_DIR?>/js/bootstrap.js"></script>
        <script src="<?=PUBLIC_DIR?>/js/mustache.js"></script>
        <script src="<?=PUBLIC_DIR?>/js/script.js"></script>
        <?php foreach($scripts as $src) { ?>
            <script src="<?php echo $src; ?>"></script>
        <?php } ?>
    </body>
</html>