<div class="left_side_bar">
<!--
    <div class="col_1">
        <h1>Main Menu</h1>
        <div class="box">
            <ul>
                <li><a href="#">Menu Item 1</a></li>
                <li><a href="#">Menu Item 2</a></li>
                <li><a href="#">Menu Item 3</a></li>
                <li><a href="#">Menu Item 4</a></li>
                <li><a href="#">Menu Item 5</a></li>
                <li><a href="#">Menu Item 6</a></li>
                <li><a href="#">Menu Item 7</a></li>
                <li><a href="#">Menu Item 8</a></li>
                <li><a href="#">Menu Item 9</a></li>
            </ul>
        </div>
    </div>
-->
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