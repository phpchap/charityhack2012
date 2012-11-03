<!-- THREAD HEADER -->
<div class="well">
    <h3>Register</h3>
</div>

<!-- START NEW THREAD FORM -->
<form action="<?php echo url_for('@registration'); ?>" method="POST" enctype="multipart/form-data"> 

<table>
<?php echo $form; ?>
</table>
    
<!-- SUBMIT BUTTON-->
<div class="control-group">
    <input type="submit" value="Submit" class="btn btn-success">
</div>    

</form>