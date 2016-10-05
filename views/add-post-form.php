
<div class="row">
    <form class="col s12 m12 l12" action="." method="POST">
        <input type="hidden" name="action" value="add-post">
        <div class="row">
            <div class="input-field col s12 m12 l12">
              <input name="title" id="title" type="text" class="validate">
              <label for="title">Post Title</label>
            </div>
            <div class="input-field col s12">
                <textarea name="body" id="post_body" class="materialize-textarea"></textarea>
                <label for="body">Post Body</label>
            </div>
            <input type="submit" name="submit" value="submit" class="btn"/>
        </div>
    </form>
</div>
