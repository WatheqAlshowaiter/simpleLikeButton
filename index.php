<?php 

require_once 'app/init.php'; 

$articlesQuery = $db->query("
SELECT articles.id , 
articles.title, 

COUNT(articlesLikes.id) as likes , 
GROUP_CONCAT(users.username SEPARATOR '|') AS liked_by

from articles

left join articlesLikes 
on 
articles.id = articlesLikes.article_id

LEFT JOIN users 
on articlesLikes.user_id = users.id 

GROUP BY articles.id

"); 

while($row = $articlesQuery->fetch_object()){
    $row->liked_by = $row->liked_by ? explode('|',$row->liked_by): [];
    $articles[] = $row; 
}

// for clarity during devloping and for debugging 
// echo '<pre>', print_r($articles,true), '</pre>'; 
// die(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Articles</title>
</head>
<body>
    <?php foreach($articles as $article): ?>  
        <h3><?php echo $article->title?></h3>
        <a href="like.php?type=article&id=<?php echo $article->id;?>">like</a>
        <p><?php echo $article->likes; ?> people liked this</p>
        <?php if(!empty($article->liked_by)): ?>
        <ul>
            <?php foreach ($article->liked_by as $user):?>
                <li><?php echo $user?> </li>
            <?php endforeach; ?>
        </ul>
        <?php endif;?>

    <?php endforeach; ?>    

</body>
</html>

