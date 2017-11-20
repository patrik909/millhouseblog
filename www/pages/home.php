<?php
require 'parts/database.php';
require 'parts/functions.php';
?>

<div class="container landingpage">
        <div class="row">
            <div class="col-lg-8">
<?php
//FETCH POSTS
//MAYBE PUT THIS IN PARTS...? AS FETCH_POST T.EX..
$statement = $pdo->prepare("SELECT * FROM post ORDER by date DESC");
$statement->execute();
$post = $statement->fetchAll(PDO::FETCH_ASSOC);
$keys = array_keys($post);

 for($i=0; $i<5; $i++){
    $user_id = $post[$keys[$i]]['userid'];
    $post_id = $post[$keys[$i]]['postid'];
    $category_id = $post[$keys[$i]]['categoryid'];

    $category_name = get_row_with_input('name', 'category', 'categoryid', $category_id);
    $username = get_row_with_input('username', 'user', 'userid', $user_id);
    $user_email = get_row_with_input('email', 'user', 'userid', $user_id);

    $number_of_comments = count_comments($post_id);

    if($post_id == NULL)
    {
        //Don't display "empty" posts if posts < 5
    }
    else
    { 
    //LOOPING OUT THE POSTS
    ?>  
      <article class="post">
      <header>  
            <span class="uppercase grey"><?=$category_name?></span>
        <!--<meta>kategorierna som meta???-->
        <h2 class=”postheading”><?=$post[$keys[$i]]['title'];?></h2>
        <time class="grey"><?=$post[$keys[$i]]['date'];?></time>
        <span class="uppercase grey"><?= $username?></span>
        <span class=""><?=$user_email?></span>
        <a href="/millhouseblog/www/?page=viewpost&id=<?= $post_id ?>#comments"><?= $number_of_comments ?> kommentarer</a><!--added comments anchor-->
      </header>
      <p><?=$post[$keys[$i]]['text'];?></p>

        <nav class=””>
            <a href="/millhouseblog/www/?page=viewpost&id=<?= $post_id ?>">Läs hela inlägget</a>
        </nav>   
  </article><!--/post article-->
  <?php } 
}?>

    </div><!--/col-md-8-->

    <div class="col-lg-4 sidebar hidden-xs-down">
        <?php
        require 'components/sidebar.php';
        ?>
    </div><!--/sidebar-->

  </div><!--/row-->
</div><!--/container-->