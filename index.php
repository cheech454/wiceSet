<?php
$essid=shell_exec('iwlist wlan0 scan | grep ESSID');
$essid=str_replace('ESSID:','',$essid);
$essid=str_replace('"','',$essid);
$essid=array_filter(explode(PHP_EOL, $essid));

 ?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>IceToaster</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">

    </head>
    <body style="background-color:#eee">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-sm-offset-4">
                    <div class="panel panel-info">
                        <div class="panel-heading text-center">
                            <img src="img/logoHeaderFull.png"/>
                            <h3 class="panel-title">Wifi Setup</h3>
                        </div>
                        <div class="panel-body text-center">
                            <form id="frm1" class="form" method="post" action="setwifi.php">
                                <div class="form-group">
                                    <select class="form-control" name="essid" required>
                                        <option value='w'>Select WIFI</option>
                                        <?php foreach($essid as  $value):?>
                                            <option value="<?php echo trim($value); ?>"><?php echo trim($value); ?></option>
                                        <?php  endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="password" placeholder="wifi password" name="wifipassword" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Connect</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-4"  id="dMessage" >
                    <p class="bg-info">
                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                        Connecting to network.<br>
                        This may take a couple of minutes.<br>
                        Please be patient.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-sm-offset-4"  id="dStatus" >
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <script>
        $(document).ready(function() {
            var status;
            $('#dMessage').hide();
            if (qs('status') == 'failed') {
                status='<p class="bg-warning lead">Failed to connect!<br>Please try again.</p>';
            }else if (qs('status') == 'success') {
                status='<p class="bg-success lead">Connected to wifi!<br><a href="reboot.php" class="btn btn-warning">Click here to  reboot the toaster.</a></p>';
            }
            $('#dStatus').html(status);
            $('#dStatus').show();
            $('#frm1').submit(function() {
                $('#dMessage').show();
                $('#dStatus').hide();
            });
        });
        function qs(key) {
            key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx control chars
            var match = location.search.match(new RegExp("[?&]" + key + "=([^&]+)(&|$)"));
            return match && decodeURIComponent(match[1].replace(/\+/g, " "));
        }
        </script>
    </body>
</html>
