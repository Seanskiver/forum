
<div class="row">
    <div class="col s12 m12 l12">
        <div class="card-panel post">
            <h4><i class="material-icons">query_builder</i>&nbsp;Recent Posts</h4>
            <hr>
            <?php foreach ($allPosts as $p) : ?>

            <div class="card-panel post">
                <a class="title" href=".?action=view_post&id=<?= $p['id'] ?>"><?= $p['title'] ?></a>
                <span class="post_info">posted  on <?= date_parse($p['posted_at'])['month'].'/'.date_parse($p['posted_at'])['day']?> by <a href=""><?= $p['username'] ?></a></span><br>
                <span class="post_info"><?= $p['num_comments'] ?> comments </span>
            </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>