<?php if (isset($_SESSION['username'])) : ?>
    <div class="row">
        <div class="card-panel post col s12 m10 l10 offset-l1 offset-m1">
        <h4>New Post</h4>
        
        <form class="col s12 m12 l12" action="." method="POST">
            <input type="hidden" name="action" value="add-post">
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    <input name="title" id="title" type="text" class="validate" value="<?php echo htmlspecialchars($title);?>">
                    <label for="title">Post Title</label>
                    <?= $fields->getField('title')->getHTML(); ?>
                </div>
                <div class="input-field col s12">
                    <textarea rows="10" cols="60" id="post_body" name="post_body" class="materialize-textarea" value="<?php echo htmlspecialchars($body);?>"></textarea>
                    <label for="post_body">Post Body</label>
                    <?= $fields->getField('post_body')->getHTML(); ?>
                </div>
                
                <input type="submit" class="btn" value="Submit">
            </div>
        </form>
        </div>
    </div>
<?php endif; ?> 

