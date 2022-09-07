<!DOCTYPE html>
<body>
    <h1> Page Title : <?php echo renderSection('title'); ?> </h1>
    <?php echo renderSection('content'); ?>
    <?= $message;?>
<?php stack(); ?>
    <script src="stack-1.js"></script>
    <script src="stack-2.js"></script>
<?php endStack(); ?>
</body>
</html>