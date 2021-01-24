<!-- header goes here -->
<?php
    include('fragments/header.php');
?>

<!-- left side bar goes here -->
<?php
    include('fragments/left_side_bar.php');
?>
<!-- Welcomes the user and tells him what this website does -->
<div class="right_section">
    <div class="common_content">
        <h2>Welcome</h2>
        <hr>
        <p>This website lets you send and receive messages!</p>
        <p>Get started and <a href="mailbox.php?compose=true" class="btn">
                Compose a message
            </a></p>
        <br>
        <br>
        <p>In the meantime, please enjoy some cat facts :</p>
        <br>
        <ul>
            <?php for ($i = 0; $i < rand(3, 9); $i++) : ?>
                <li><?php $json = file_get_contents('https://catfact.ninja/fact');
                        $obj = json_decode($json);
                        echo $obj->fact; ?></li>
            <?php endfor; ?>
        </ul>
    </div>

</div>

<!-- footer goes here -->
<?php
    include('fragments/footer.php');
?>