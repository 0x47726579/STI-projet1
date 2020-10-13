<div class="left_side_bar">
    <div class="col_1">
        <h1>Cat Facts</h1>
        <?php for ($i = 0; $i < 2; $i++) : ?>
            <div class="box">
                <p><?php $json = file_get_contents('https://catfact.ninja/fact');
                        $obj = json_decode($json);
                        echo $obj->fact; ?></p>
            </div>
        <?php endfor; ?>
    </div>
</div>