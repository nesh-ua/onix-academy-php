<?php if (!empty($_GET)): ?>
    <?php
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'post' => $_GET,
            'server' => $_SERVER
        ]);
    ?>
<?php elseif (!empty($_POST)): ?>
    <?php
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'post' => $_POST,
            'server' => $_SERVER
        ]);
    ?>
<?php else: ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Title</title>
    </head>
    <body>
        <form action="/" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"/><br>
            <label for="request">Request:</label><br>
            <input type="text" id="request" name="request" /><br>
            <input type="submit" value="Send">
        </form>
    </body>
</html>
<?php endif; ?>



