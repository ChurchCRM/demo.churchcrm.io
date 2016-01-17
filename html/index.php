<?php
$composerFile = file_get_contents(dirname(__FILE__)."/master/composer.json");
$masterJson = json_decode($composerFile, true);

$composerFile = file_get_contents(dirname(__FILE__)."/develop/composer.json");
$developJson = json_decode($composerFile, true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ChurchCRM Demo Sites</title>

    <link href="theme.css" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:100,400,300,400italic,500' rel='stylesheet' type='text/css'>
    <!-- Font-Awesome -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>


<div class="more">
    <div class="container">
        <br/><p/><br/>
        <h1 class="text-center">Church<b>CRM</b> - An OpenSource CRM System Built for Churches</h1>
        <h3 class="text-center">Take a Demo system for a Test drive</h3>
        <br/><p/><br/>
        <div class="row">
            <div class="col-md-6">
                <div class="thumbnail">
                    <img src="https://camo.githubusercontent.com/9ade378b5c27173686685bb380f78301ab94bc1c/687474703a2f2f7777772e63687572636863726d2e696f2f73637265656e73686f74732f6d656e752e504e47">

                    <div class="caption">
                        <h3>Master <?= $masterJson['version'] ?> Build</h3>
			<p><a href="https://github.com/ChurchCRM/CRM/commit/<?= $masterJson['commitHash'] ?>">(<?= $masterJson['commitHash'] ?>)</a></p>                        <p>user: admin | password: george</p>
                        <p>
                            <a href="/master"
                               class="btn btn-primary" role="button"><i class="fa fa-car fa-fw"></i> Test Drive a Preview</a>
                            <a href="https://github.com/ChurchCRM/CRM/tree/master"
                               class="btn btn-success" role="button"><i class="fa fa-github fa-fw"></i> View On github</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="thumbnail">
                    <img src="https://camo.githubusercontent.com/9ade378b5c27173686685bb380f78301ab94bc1c/687474703a2f2f7777772e63687572636863726d2e696f2f73637265656e73686f74732f6d656e752e504e47">

                    <div class="caption">
                        <h3>Development <?= $developJson['version'] ?> - Beta</h3>
			<p><a href="https://github.com/ChurchCRM/CRM/commit/<?= $developJson['commitHash'] ?>">(<?= $developJson['commitHash'] ?>)</a></p>
                        <p>user: admin | password: george</p>
                        <p>
                            <a href="/develop"
                               class="btn btn-primary" role="button"><i class="fa fa-car fa-fw"></i> Test Drive a Preview</a>
                            <a href="https://github.com/ChurchCRM/CRM/tree/develop"
                               class="btn btn-success" role="button"><i class="fa fa-github fa-fw"></i> View On github</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</div>
<!-- /.more -->



    <script>
  ((window.gitter = {}).chat = {}).options = {
    room: 'churchcrm/crm'
  };
</script>
<script src="https://sidecar.gitter.im/dist/sidecar.v1.js" async defer></script>


</body>
</html>