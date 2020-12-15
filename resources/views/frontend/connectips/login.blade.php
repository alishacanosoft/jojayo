<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ConnectIps Payment</title>
</head>

<body>
    <form action="https://uat.connectips.com:443/connectipswebgw/loginpage" name="connect" method="post">
        <input type="hidden" name="MERCHANTID" id="MERCHANTID" value="{{ $data['MERCHANTID'] }}" />
        <input type="hidden" name="APPID" id="APPID" value="{{ $data['APPID'] }}" />
        <input type="hidden" name="APPNAME" id="APPNAME" value="{{ $data['APPNAME'] }}" />
        <input type="hidden" name="TXNID" id="TXNID" value="{{ $data['TXNID'] }}" />
        <input type="hidden" name="TXNDATE" id="TXNDATE" value="{{ $data['TXNDATE'] }}" />
        <input type="hidden" name="TXNCRNCY" id="TXNCRNCY" value="{{ $data['TXNCRNCY'] }}" />
        <input type="hidden" name="TXNAMT" id="TXNAMT" value="1234" />
        <input type="hidden" name="REFERENCEID" id="REFERENCEID" value="{{ $data['REFERENCEID'] }}" />
        <input type="hidden" name="REMARKS" id="REMARKS" value="{{ $data['REMARKS'] }}" />
        <input type="hidden" name="PARTICULARS" id="PARTICULARS" value="{{ $data['PARTICULARS'] }}" />
        <input type="hidden" name="TOKEN" id="TOKEN" value="{{ $data['TOKEN'] }}" />
        <input type="submit" value="Submit">
    </form>
    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
        window.onload = function() {
            document.forms['connect'].submit();
        }

    </script>
</body>

</html>
