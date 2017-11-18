<?php
require 'parts/database.php';
require 'parts/functions.php';

// 1. VI BEHÖVER HÄMTA USERID (KOPIERA SAMMA LOGIK SOM VI HAR GET PARAMETERN PAGE OCH ÄNDRA DEN TILL USERID)

$userid = $_SESSION["user"]["userid"];

// 2. HÄMTA EN ANVÄNDARE FRÅN DATABASEN SOM HAR DET USERID SOM VI FICK FRÅN GET-PARAMETERN (SE KODEN I LOGIN HUR VI HÄMTAR USERINFORMATION FRÅN DATABASEN)

$statement = $pdo->prepare("SELECT username, userid, email, name, role, registertime FROM user WHERE userid = :userid");

$statement->execute(array(
":userid" => $userid
));

$fetched_user = $statement->fetch(PDO::FETCH_ASSOC);

?>

<div class="container-fluid profile_header">
     <div class="row">
        <div class="col-4 offset-4">
                <img src="images/clocks.jpg" id=profile_avatar alt="Avatar för användare" class="rounded-circle" width="150px" height="150px">
                <h1> <?php echo $fetched_user["name"]; ?> </h1>
                <p>XX inlägg med XX kommentarer </p>
                <p> Gick med <?php echo $fetched_user["registertime"];?> </p>
        </div>
    </div>
</div>

<div class="container profile_content">
    <div class="row">
        <div class="col-4 offset-4">
            <a class="btn" href="/millhouseblog/www/?page=createpost">Skriv nytt inlägg
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
        </div> 
    </div>
     
    <?php
    //FETCH POSTS BY LOGGED IN USER, USING THE SAME STRUCTURE AS IN HOME
    $statement = $pdo->prepare("SELECT * FROM post WHERE userid = {$userid} ORDER by date DESC");
    $statement->execute();
    $post = $statement->fetchAll(PDO::FETCH_ASSOC);
    $keys = array_keys($post);

    for($i=0; $i<5; $i++):
    $user_id = $post[$keys[$i]]['userid'];
    $post_id = $post[$keys[$i]]['postid'];
    $category_id = $post[$keys[$i]]['categoryid'];

    $category_name = get_row_with_input('name', 'category', 'categoryid', $category_id);
    $username = get_row_with_input('username', 'user', 'userid', $user_id);

    $number_of_comments = count_comments($post_id);
    
    if($post_id == NULL)
    {
        //Don't display "empty" posts if posts < 5
    }
    else
    { 
    ?>  

    <div class="row">
        <div class="col-12 col-lg-8 offset-lg-2">    
            <article class="post">
                <header>  
                <span class="uppercase grey"><?=$category_name?></span>
                <h2 class=”postheading”><?=$post[$keys[$i]]['title'];?></h2>
                <time class="grey"><?=$post[$keys[$i]]['date'];?></time>
                <span class="uppercase grey"><?= $username?></span>
                <a href="/millhouseblog/www/?page=viewpost&id=<?= $post_id ?>"><?= $number_of_comments ?> kommentarer</a>
                </header>
                <p><?=$post[$keys[$i]]['text'];?></p>
                <a href="/millhouseblog/www/?page=viewpost&id=<?= $post_id ?>">Läs hela inlägget</a>
            </article>
        </div> <!-- Closing row for each post-->
    </div> <!-- Closing col for each post -->

    <?php } ?>
    <?php endfor; ?>
</div> <!-- Closing container profile content -->