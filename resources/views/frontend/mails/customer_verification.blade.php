<!DOCTYPE html>
<html>
  <head>
    <title>Welcome Email</title>
  </head>
  <body>
    <h2>Welcome to the site Alisha Lamichhane</h2>
    <br/>
    Your registered email-id is {{ $customer_data['email'] }} , Please click on the below link to verify your email account to start purchasing from Jojayo.
    <br/>
    <a href="{{url('user/verify', $customer_data['email'])}}">Verify Email</a>
  </body>
</html>
