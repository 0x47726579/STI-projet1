<div class="left_side_bar">
    <div class="col_1">
        <h1>Cat Facts</h1>
        <div class="box">
            <p>
                <?php
                    $json = file_get_contents('https://catfact.ninja/fact');
                    $obj = json_decode($json);
                    echo $obj->fact;
                ?>
            </p>
        </div>
        <div class="box">
            <p>
                <?php
                    $json = file_get_contents('https://catfact.ninja/fact');
                    $obj = json_decode($json);
                    echo $obj->fact;
                ?>
            </p>
        </div>
    </div>
</div>