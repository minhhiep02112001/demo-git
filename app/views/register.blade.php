<!DOCTYPE html>
<html>
<body>

<h2>Register</h2>

<form action="{{url('register')}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= csrf_token(); ?>">
    <label for="fname">Image:</label><br>
    <input type="file" id="image" name="image" ><br>
    <label for="fname">First name:</label><br>
    <input type="text" id="fname" name="fname" value="John"><br>
    <label for="lname">Last name:</label><br>
    <input type="text" id="lname" name="lname" value="Doe"><br><br>
    <input type="submit" value="Submit">
</form>

<p>If you click the "Submit" button, the form-data will be sent to a page called "/action_page.php".</p>

</body>
</html>
