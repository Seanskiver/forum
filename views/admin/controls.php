<div class="row">
    <div class="card-panel col s12 m12 l12">
        <h4>Users</h4>
        <table class="striped">
            <thead>
                <tr>
                    <th data-field="id">Id</th>
                    <th data-field="username">Username</th>
                    <th data-field="created">Created</th>
                    <th data-field="delete">Delete</th>
                </tr>
            </thead>
        
            <tbody>
                <?php foreach ($users as $u) : ?>
                    <tr>
                        <td><?= $u['id']; ?></td>
                        <td><?= $u['username'] ?></td>
                        <td><?= $u['created_at'] ?></td>
                        <td><a href=".?action=admin-delete-user&id=<?= $u['id'] ?>" class="btn red">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>        
    </div>

    <div class="card-panel col s12 m12 l12">
        <h4>Posts</h4>
        
        <table class="striped">
            <thead>
                <tr>
                    <th data-field="id">Id</th>
                    <th data-field="title">Title</th>
                    <th data-field="created_by">Author</th>
                    <th data-field="created_at">Posted at</th>
                    <th data-field="delete">Delete</th>
                </tr>
            </thead>
        
            <tbody>
                <?php foreach ($posts as $p) : ?>
                    <tr>
                        <td><?= $p['id']; ?></td>
                        <td><a href=".?action=view_post&id=<?= $p['id'] ?>"><?= $p['title'] ?></a></td>
                        <td><?= $p['username'] ?></td>
                        <td><?= $p['posted_at'] ?></td>
                        <td><a href=".?action=admin-delete-post&id=<?= $u['id'] ?>" class="btn red">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>      
    </div>    
        
</div>