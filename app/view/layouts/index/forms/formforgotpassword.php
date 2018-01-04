<button class="btn btn-primary" onclick="sendEmail()">test</button>

<script>
    function sendEmail(){
        $.ajax({
            url: '/home/sendRecover/',
            type: 'POST'
        });
    }
</script>