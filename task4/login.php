<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>

        <link rel="stylesheet" href="/task4/assets/styles/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
    
          <form class="form-signin" method="POST" action="/task4/index.php">
            <h2 class="form-signin-heading">Please sign in</h2>
            <label for="inputUsername" class="sr-only">User name</label>
            <input name="username" type="text" id="inputUsername" class="form-control" placeholder="User name" required="" autofocus="">
            <label for="inputPassword" class="sr-only">Password</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
          </form>
    
        </div>
        <script src="/task4/assets/scripts/jquery-3.2.1.min.js" ></script>
        <script src="/task4/assets/scripts/bootstrap.min.js" ></script>
    </body>
</html>


