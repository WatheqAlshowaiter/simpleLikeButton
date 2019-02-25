<?php 

require_once 'app/init.php'; 

if (isset($_GET['type'], $_GET['id'])){
    $type = $_GET['type']; 
    $id = (int)$_GET['id']; 

    switch($type){
        case 'article' : 
            // echo "ok"; // for testing

            // we'll make 3 request (one query for performance)
            // for articled existince 
            // and for make sure if user liked article before or not 
            // and for insert like to db 

            $db->query("
                INSERT INTO articlesLikes (user_id, article_id) 
                    SELECT {$_SESSION['user_id']} , {$id}
                    FROM articles 
                    WHERE EXISTS (
                        SELECT id 
                        FROM articles 
                        WHERE id = {$id} 
                    )
                    AND  NOT EXISTS (
                        SELECT id 
                        FROM articlesLikes 
                        WHERE user_id = {$_SESSION['user_id']}
                        AND article_id ={$id} 
                    )
                    LIMIT 1 
            ");
        break; 

    }

    header ("Location: index.php"); 


}