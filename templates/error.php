<?php include('header.php'); ?>

    <h1>ERROR</h1>
    <p class="error">
        <?php echo $result['error']; ?>

        <?php echo json_encode($result); ?>
    </p>

<?php include('footer.php'); ?>