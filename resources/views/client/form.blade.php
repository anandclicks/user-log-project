<!-- Add jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form id="emailForm">
    @csrf
    <input type="text" name="name" placeholder="Your Name">
    <input type="email" name="email" placeholder="Your Email">
    <input type="number" name="number" placeholder="Enter Number">
    <input type="submit" value="Submit">
</form>

<div id="response"></div>

<script>
    $(document).ready(function() {
        $('#emailForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "/email",
                type: "POST",
                data: $(this).serialize(), 
                success: function(response) {
                    $('#response').html('<p style="color: green;">' + response.message + '</p>');
                },
                error: function(xhr) {
                    $('#response').html('<p style="color: red;">Something went wrong</p>');
                }
            });
        });
    });
</script>
