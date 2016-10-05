$('.lnk-reply').click(function() {
    $('.reply-form').hide();
    $('.reply-form[data-reply='+$(this).attr('data-reply')+']').show();
    
});

$('.reply-cancel').click(function() {
    $(this).closest('.reply-form').hide();
});

$('.edit-comment').click(function() {
    // use data-id to reference this post specifically
    var id = $(this).attr('data-edit');
    // Get the comment body of this post
    var commentBody = $('div[data-id='+id+']').find('.comment-body').text();
    
    // hide the comment body
    $('div[data-id='+id+']').find('.comment-body').hide();
    
    //show the edit form
    $('div[data-id='+id+']').find('.edit-comment-form').show();
    
    //console.log($('div[data-id='+id+']').find('.edit-comment-body'));
    $('div[data-id='+id+']').find('label[for=comment-edit-body]').addClass('active');
    $('div[data-id='+id+']').find('.edit-comment-body').addClass('active');
    $('div[data-id='+id+']').find('.edit-comment-body').val(commentBody);
    
    
    $(this).closest('.edit-comment-form').show(); 
});

$('.edit-cancel').click(function() {
    $(this).closest('.edit-comment-form').hide();
    $(this).parent().siblings('.comment-body').show();
});