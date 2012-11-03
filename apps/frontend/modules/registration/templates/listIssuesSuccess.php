
<!-- THREAD HEADER -->
<div class="well">
    <h3>Select Issues</h3>
</div>

<p>Choose which open issues need to be fixed and add a donation amount</p>

<!-- START NEW THREAD FORM -->
<form action="<?php echo url_for('@list_user_issues'); ?>" method="POST" enctype="multipart/form-data"> 
   
<?php foreach($userRepoIssues as $userRepo) { ?>
    <ul>
        <li>
            <?php echo $userRepo['repo']; ?>        
            <?php if(count($userRepo['issue']) > 0) { ?> 
                <?php foreach($userRepo['issue'] as $issue) {  ?>                
                    <p>
                        <input type="hidden" name="repo_id[]" value="<?php echo $userRepo['repo_id']; ?>">                         
                        <input type="hidden" name="issue_id[]" value="<?php print ($issue['id']); ?>"> 
                        <input type="hidden" name="issue_number[]" value="<?php print ($issue['number']); ?>"> 
                        <a href="<?php echo $issue['html_url']; ?>" target="_blank"><?php echo $issue['title']; ?></a>
                        :: Donation Amount £ <input type="text" name="issue_value[]" value="">
                    </p>
                    <?php /* <p> print($issue['body']); ?></p> */ ?>
                    <?php if(!empty($issue['user'])) { ?>
                        <?php /* <p><a href="<?php print($issue['user']['url']); ?>"><img height="100" width="100" src="<?php print($issue['user']['avatar_url']); ?>"></a></p> */ ?>
                        <?php /* <p><a href="<?php print($issue['user']['url']); ?>"><?php echo print($issue['user']['login']); ?></a></p>  */ ?>                      
                    <?php } ?></p>            
                <?php } ?>
            <?php } ?>
            <hr>
        </li>
    </ul>        
<?php } ?>
    
<!-- SUBMIT BUTTON-->
<div class="control-group">
    <input type="submit" value="Submit" class="btn btn-success">
</div>    

</form>