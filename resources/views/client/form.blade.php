<!-- Add jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form id="emailForm">
    @csrf
    <input type="text" name="name" placeholder="Your Name">
    <input type="number" name="number" placeholder="Your number">
    <select name="pg">
        <option value="NOD101">NH2NOD101</option>
        <option value="NOD416">NH2NOD416</option>
        <option value="NOD438">NH2NOD438</option>
        <option value="NOD401">NH2NOD401</option>
    </select>
    <select name="sharing_type">
        <option value="Single Sharing">Single Sharing</option>
        <option value="Double Sharing">Double Sharing</option>
        <option value="Triple Sharing">Triple Sharing</option>
    </select>
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
