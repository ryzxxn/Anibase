<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,200&display=swap" rel="stylesheet">
    </head>
    <?php
        ini_set('display_errors', 0);
        $search_input = $_POST["anime_input"];
    ?>
    <body>
        <div class="navbar">
            <a href="index.php" class="title">Anibase</a>
            <div class="search">
                <form action="index.php" method="post">
                    <input name="anime_input" placeholder="Search..." type="text" class="searchbox">
                    <button class="searchbutton" type="submit">🔍</button>
                </form>
            </div>
        </div>

        <?php
        if($search_input != NULL)
        {
            //echo $search_input;
        }
        else{
            //echo "search_empty";
        }

        $animeName = $search_input;
                $mal_id = NULL;
                $jikanurl = "https://api.jikan.moe/v4/anime?q=".urlencode($animeName);

                // Read JSON file
                $jikan_data = file_get_contents($jikanurl);
            
                $jikan_response = json_decode($jikan_data);
                //print_r($jikan_response);

                $mal_id = $jikan_response->data[0]->mal_id;

                //echo urlencode($animeName);
                //echo "<br>";
                //echo $mal_id;
        ?>

        <div class="mainpage">
            <?php
                $total = $jikan_response->pagination->items->total;
                $count = $jikan_response->pagination->items->count;
                //echo $total;
                //echo "<br>";
                //echo $count;

                for ($j=0; $j <$count; $j++) { 
                    $url = $jikan_response->data[$j]->url;
                    $name = $jikan_response->data[$j]->title;
                    $status = $jikan_response->data[$j]->status;
                    $episodes = $jikan_response->data[$j]->episodes;
                    $rating = $jikan_response->data[$j]->rating;
                    $i_url = $jikan_response->data[$j]->images->jpg->image_url;
                    $synopsis = $jikan_response->data[$j]->synopsis;

                    echo '<div class = "tab">';
                        echo '<div class = "img">';
                            echo '<img class = "img_im" src="'.$i_url.'" alt="">';   
                        echo '</div>';

                        echo '<div class = "details">'; 
                            echo "<a class = 'link' href='$url'>$name</a>"; 
                            //echo $name;
                            echo "<br>";
                            echo "Status : ".$status;
                            echo "<br>";
                                if ($status == 'Currently Airing') {
                                    echo "Episodes : on-going";
                                }
                                else
                                {
                                    echo "Episodes : ".$episodes;
                                }
                            echo "<br>";
                            echo "Rating : ".$rating;
                            //echo "Discription : ";
                            //echo $synopsis;
                            //echo "<br>"; 
                            //echo "<a class = 'link' href='$url'>$name</a>";
                        echo '</div>';
                    echo '</div>';
                }
                //print_r($jikan_response);
            ?>
        </div>
    </body>
</html>