<!-- THREAD HEADER -->
<div class="well">
    <h3>Select a Repo</h3>
</div>

<p>Choose a repository with open issues</p>

<?php if(count($userRepos) > 0) { ?>
    <ul>
        <!-- START NEW THREAD FORM -->
        <form action="<?php echo url_for('@list_user_repo'); ?>" method="POST" enctype="multipart/form-data"> 
        <?php foreach($userRepos as $userRepo) { ?>       
            <?php if($userRepo['open_issues'] > 0) { ?>
                <li>                             
                    <p>
                        <input type="checkbox" name="repo_name[]" value="<?php print($userRepo['name']); ?>">
                        <a href="<?php print($userRepo['url']); ?>" target="_blank"><?php print($userRepo['name']); ?></a>
                    </p>
                    <p><?php print($userRepo['description']); ?></p>                
                    <p><?php print($userRepo['open_issues']); ?> Issues</p>            
                </li>
            <?php } ?>            
        <?php } ?>    
    </ul>
    <!-- SUBMIT BUTTON-->
    <div class="control-group">
        <input type="submit" value="Submit" class="btn btn-success">
    </div>    
<?php } else { ?>
    <p>Sorry, we couldnt find any repo's for you - <a href="http://www.github.com">you can create one on github.com<a></p>    
<?php } ?>

