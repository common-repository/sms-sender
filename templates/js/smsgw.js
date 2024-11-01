
if(typeof jQuery!='undefined') {
    $=jQuery;
    
    function print_message($message, $class) {
        $class = $class || 'error';
        $('#topmessage').html('<div class="'+$class+'"><p>'+$message+'.</p></div>');
    }

    jQuery(document).ready(function(){

        $('a[href*=delete],.delete').click(function(){
            return(confirm('Are you sure?'));
        });

        $("#groups,#contacts").multipleSelect({
            filter: true
        });
        $("#smsgwnet_api_provider").multipleSelect({
            single: true
        });

        $("#groups,#contacts").change(function(){
            $('#smsmessage').keyup();
        });

        $('#send').click(function(){
            $('#smsmessage').keyup();
            if($('#groups option:selected').length == 0 && $('#contacts option:selected').length==0) {
                print_message('Please select groups or contacts to send the message.');
                return false;
            }
            if($('#smsmessage').val().length == 0) {
                print_message('Please write the message.');
                return false;
            }
        });
        $('#smsmessage').keyup(function(){
            //$('#smsmessage').val($.trim($('#smsmessage').val()));
            $length = Math.ceil($('#smsmessage').val().length/70);
            $count  = 0;
            $('#groups option:selected').each(function(){
                $count = $count + $(this).data('count');
            });
            $('#contacts option:selected').each(function(){
                $count = $count + 1;
            });
            $('#countmessages').html($('#smsmessage').val().length + ' Chars, ' +parseInt($count * $length) + ' points');
        });

    });
}