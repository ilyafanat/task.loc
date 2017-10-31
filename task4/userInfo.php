<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>User info</title>

        <link rel="stylesheet" href="/task4/assets/styles/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">Retrive your phone number</div>
                <div class="panel-body">
                    <form class="form-add-user-info" action="/task4/index.php" method="post">
                        <h3 class="form-add-user-info-heading">Option1. Add your phone number</h3>
                        <label for="phone" class="sr-only">Enter yor phone</label>
                        <input name="phone" type="text" id="phone" class="form-control" placeholder="Phone" required="" autofocus="">
                        <label for="email" class="sr-only">Enter yor email</label>
                        <input name="email" type="email" id="email" class="form-control" placeholder="Email" required="">
                        <input name="add" type="hidden" value="add">
                        <button class="btn btn-lg btn-primary btn-block add-submit" type="submit">Submit</button>
                    </form>
                </div>
            </div>

            <br />

            <div class="panel panel-default">
                <div class="panel-heading">Retrive your phone number</div>
                <div class="panel-body">
                    <form class="form-show-user-phone" action="/task4/index.php" method="post">
                        <h3 class="form-show-user-info-heading">Option2. Retrive your phone number</h3>
                        <label for="email" class="sr-only">Enter yor email</label>
                        <input name="email" type="email" id="email" class="form-control" placeholder="Email" required="">
                        <input name="show" type="hidden" value="show">
                        <button class="btn btn-lg btn-primary btn-block show-submit" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <script src="/task4/assets/scripts/jquery-3.2.1.min.js" ></script>
        <script src="/task4/assets/scripts/bootstrap.min.js" ></script>
        <script src="/task4/assets/scripts/script.js" ></script>
    </body>

</html>
