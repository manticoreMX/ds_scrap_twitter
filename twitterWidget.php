<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<div id="container"></div>
<div id="tweets-carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#tweets-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#tweets-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<script src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<?php
if (isset($_GET["page"])) {
    $options = array();
    $options["show-replies"] = $_GET["show-replies"];
    $options["dnt"] = $_GET["dnt"];
    $options["theme"] = $_GET["theme"];
    if ($_GET["chrome"] != "") {
        $options["chrome"] = $_GET["chrome"];
    }
    if (intval($_GET["width"]) > 0) {
        $options["width"] = intval($_GET["width"]);
    }
    if (intval($_GET["height"]) > 0) {
        $options["height"] = intval($_GET["height"]);
    }
    $options["tweet-limit"] = intval($_GET["tweet-limit"]);

    if ($_GET["timeline"] == "true") { ?>
        <script>
            twttr.widgets.createTimeline({
                    sourceType: "profile",
                    screenName: "<?= $_GET["page"] ?>"
                },
                document.getElementById("container"),
                    <?= json_encode($options) ?>
                );
        </script>
    <?php } else if ($_GET["timeline"] == "false") { 
            $token = "AAAAAAAAAAAAAAAAAAAAAGvQNgEAAAAA8Z3i%2FrTUjK21hj0VOtNYNTJ%2FwYU%3Dyzc6dFbxXX9hxqXFJRUu7ogeEwkAa0AWUiQ1tqbviQc5WubjgL";
            $authorization = "Authorization: Bearer $token";
            $ch = curl_init('https://api.twitter.com/2/tweets/search/recent?query=from:'.$_GET["page"].'&max_results='.intval($_GET["tweet-limit"]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        
            $response = curl_exec($ch);

            curl_close($ch); 

            $tweets = json_decode($response);
            //var_dump($tweets);
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php
                $initial = 0;
                foreach ($tweets->data as $key => $value) {
                ?>
                    let newDiv<?=$value->id?> = document.createElement('div')
                    newDiv<?=$value->id?>.className = "carousel-item <?=$initial == 0 ? 'active': '';?>"
                    document.querySelector('.carousel-inner').appendChild(newDiv<?=$value->id?>)
                    twttr.widgets.createTweet(
                    '<?=$value->id?>',
                    newDiv<?=$value->id?>, 
                        <?= json_encode($options) ?>
                    );
                <?php
                    $initial++;
                }
                ?>
                
            })
        </script>
<?php }
}
?>