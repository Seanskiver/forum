<div class="row">
        <div class="card-panel post col s12 m8 l8 offset-l2 offset-m2">
            <h4 class="col s12 m10 l10 offset-l1 offset-m1">Sign up</h4>

            <form class="" action="." method="POST">
                <input type="hidden" name="action" value="signup">
                
                <div class="input-field col s12 m10 l10 offset-l1 offset-m1">
                    <i class="small material-icons prefix">account_circle</i>     
                    <input name="username" id="username" type="text" class="validate" value="<?php echo htmlspecialchars($username);?>">
                    <label for="username">Username</label>
                    <?= $fields->getField('username')->getHTML(); ?>
                    <div id="usernameErr"><?= $fields->getField('userError')->getHTML(); ?></div>
                </div>  
                
                <div class="input-field col s12 m10 l10 offset-l1 offset-m1">
                    <i class="material-icons prefix">lock</i>  
                  <input name="password" id="password" type="password" class="validate">
                  <label for="password">Password</label>
                  <?= $fields->getField('password')->getHTML(); ?>
                </div>
                
                <div class="input-field col s12 m10 l10 offset-l1 offset-m1">
                    <i class="material-icons prefix">lock</i>                  
                    <input name="password_verify" id="verify" type="password" class="validate">
                    <label for="password_verify">Verify Password</label>
                    <?= $fields->getField('password_verify')->getHTML(); ?>
                </div>
                
                <div class="input-field col s12 m10 l10 offset-l1 offset-m1">
                    <input style="margin-bottom: 20px;" id="submit" type="submit" name="submit" value="submit" class="btn"/>
                </div>
            </form>
        </div>
</div>


