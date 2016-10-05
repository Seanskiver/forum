<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-panel post">
            <a class="title" href=".?action=view_post&id=<?= $onePost['id'] ?>"><?= $onePost['title'] ?></a>
            <p class="post-body"><?= $onePost['body']; ?></p>
            <span class="post_info">posted on <?= date_parse($onePostost['posted_at'])['month'].'/'.date_parse($onePost['posted_at'])['day']?> by <a href=""><?= $onePost['username'] ?></a></span><br>
            <span class="post_info"><?= $onePost['num_comments'] ?> comments </span>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['user_id'])) : ?>
<!-- COMMENT FORM -->
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-panel post">
            <span id="comment-header">Leave a comment</span>

            <form id="comment-form" action="." method="POST" >
                <input type="hidden" name="postId" value="<?= $onePost['id'] ?>"/>
                <input type="hidden" name="action" value="add-comment">
                    <div class="input-field col s12">
                        <textarea name="body" id="post_body" class="materialize-textarea"></textarea>
                        <label for="body">Comment body</label>
                    </div>
                    <input type="submit" name="submit" value="submit" class="btn"/>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!--COMMENTS-->
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-panel post">
            <h5 class="card-title">Comments</h5>
            <hr>

            <?php foreach ($comments as $c) : ?>
            <!--COMMENT-->
                <div class="card-panel post" data-id="<?= $c['id'] ?>">
                    <b><?= $c['username'] ?></b>
                    <div class="comment-body">&nbsp;&nbsp;<?= $c['body'] ?></div>
                    
                    <!--REPLY FORM-->
                    <form class="reply-form" action="." method="POST" data-reply="<?= $c['id'] ?>">
                        <input type="hidden" name="postId" value="<?= $onePost['id'] ?>"/>
                        <input type="hidden" name="parentId" value="<?= $c['id'] ?>">
                        <input type="hidden" name="action" value="reply">
                            <div class="input-field col s12">
                                <textarea name="body" id="post_body" class="materialize-textarea"></textarea>
                                <label for="body">Comment body</label>
                            </div>
                            <input type="submit" name="submit" value="submit" class="btn"/>
                            <button type="button" href="##" class="btn grey reply-cancel" >Cancel</button>
                    </form>
                    
                     <!--EDIT FORM-->
                    <form class="edit-comment-form" action="." method="POST">
                        <input type="hidden" name="postId" value="<?= $onePost['id'] ?> ">
                        <input type="hidden" name="commentId" value="<?= $c['id'] ?>">
                        <input type="hidden" name="action" value="edit-comment">
                        
                        <div class="input-field col s12">
                            <textarea name="body" class="materialize-textarea edit-comment-body"></textarea>
                            <label for="comment-edit-body">Comment body</label>
                        </div>
                        <input type="submit" name="submit" value="submit" class="btn"/>
                        <button type="button" href="##" class="btn grey edit-cancel" >Cancel</button>
                    </form>                    
                    
                    <!--REPLY / EDIT / DELETE CONTROLS-->
                    <ul class="comment-controls">
                        <?php if(isset($_SESSION['user_id']))  : ?>
                            <li><a href="#!" class="lnk-reply" data-reply="<?= $c['id'] ?>">Reply</a></li>
                        <?php endif; ?>
                        <?php if ($c['user_id'] === $_SESSION['user_id'] || $_SESSION['admin'] == 1) : ?>
                            <li><a href="#!" class="edit-comment" data-edit="<?= $c['id'] ?>">Edit</a></li>
                            <li><a href=".?action=delete-comment&commentId=<?= $c['id'] ?>&postId=<?= $onePost['id'] ?>">Delete</a></li>
                        <?php endif; ?>
                    </ul>
                     

                     
                     <!--REPLIES-->
                     <?php if ($c['num_replies'] > 0) : ?>
                         <?php $replies = $comment->getReplies($c['id']); ?>
                         <?php foreach ($replies as $r) : ?>
                             <div class="card-panel blue-grey lighten-5 post">
                                <b><?= $r['username'] ?></b><br>
                                <?= $r['body'] ?>
                                <?php if ($r['user_id'] === $_SESSION['user_id']) : ?>
                                    <ul class="comment-controls">
                                        <li><a data-edit="<?= $c['id'] ?>" class="edit-comment" href="#!">Edit</a></li>
                                        <li><a href=".?action=delete-comment&commentId=<?= $r['id'] ?>&postId=<?= $onePost['id'] ?>">Delete</a></li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                     <?php endif; ?>
                    <!--/REPLIES-->

                    <!--/REPLY FORM-->
                </div>
            <!-- /COMMENT -->
            <?php endforeach; ?>
        </div>
    </div>
</div>
