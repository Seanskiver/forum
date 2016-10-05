    </div>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
    <script src="../js/comments.js"></script>
    <script>
    
    $('#username').focus(function() {
        $('.error').text(''); 
    });
    
    $('#username').blur(function() { 
        var myData = {username : $(this).val()};
        
        
        if ($(this).val() != '') {
            $.post("checkUsername.php", myData)
            .done(function(data) {
                if (data == 'Taken') {
                    $('#usernameErr').children('.error').text('That username is already in use.').css('color', 'red');
                    $('#username').removeClass('valid').addClass('invalid');
                } else {
                    $('#usernameErr').children('.error').text('Username is available!').css('color', 'green');
                    $('#username').removeClass('invalid').addClass('valid');
                }
            });            
        }

    });

        
    </script>
</body>