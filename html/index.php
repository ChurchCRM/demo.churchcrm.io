<?php
$composerFile = file_get_contents(dirname(__FILE__)."/master/composer.json");
$masterJson = json_decode($composerFile, true);

$composerFile = file_get_contents(dirname(__FILE__)."/develop/composer.json");
$developJson = json_decode($composerFile, true);

function scan_dir($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess');

    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}

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
                    <img src="screenshot.png">

                    <div class="caption">
                        <h3>Master <?= $masterJson['version'] ?> Build</h3>
			<p>View on GitHub: <a href="https://github.com/ChurchCRM/CRM/commit/<?= $masterJson['commitHash'] ?>">(<?= $masterJson['commitHash'] ?>)</a></p>                        <p>user: admin | password: changeme</p>
                        <p>
                            <a href="/master"
                               class="btn btn-primary" role="button"><i class="fa fa-car fa-fw"></i> Test Drive a Preview</a>
                            <a href="https://github.com/ChurchCRM/CRM/tree/master"
                               class="btn btn-success" role="button"><i class="fa fa-github fa-fw"></i> View On github</a>
                        </p>
                        <br/>
                        <?php
                          $builds = scan_dir(__DIR__."/builds/master");
                          $dir="master";
                          if ( count($builds) > 0 )
                          {
                            ?>
                            <h4>Recent Build Archives</h4>
                            <ul>
                              <?php
                                $i=0;
                                foreach ($builds as $build)
                                {
                                  echo "<li><a href=\"builds/".$dir."/".$build."\">".$build."</a>".($i==0 ?" - Current":"")."</li>";
                                  $i++;
                                }
                              ?>
                            </ul>
                            <?php
                          }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="thumbnail">
                    <img src="screenshot.png">

                    <div class="caption">
                        <h3>Development <?= $developJson['version'] ?> - Beta</h3>
			<p>View on GitHub:  <a href="https://github.com/ChurchCRM/CRM/commit/<?= $developJson['commitHash'] ?>">(<?= $developJson['commitHash'] ?>)</a></p>
                        <p>user: admin | password: changeme</p>
                        <p>
                            <a href="/develop"
                               class="btn btn-primary" role="button"><i class="fa fa-car fa-fw"></i> Test Drive a Preview</a>
                            <a href="https://github.com/ChurchCRM/CRM/tree/develop"
                               class="btn btn-success" role="button"><i class="fa fa-github fa-fw"></i> View On github</a>
                        </p>
                        <br/>
                        <?php
                          $builds = scan_dir(__DIR__."/builds/develop");
                          $dir="develop";
                          if ( count($builds) > 0 )
                          {
                            ?>
                            <h4>Recent Build Archives</h4>
                            <ul>
                              <?php
                              $i=0;
                                foreach ($builds as $build)
                                {
                                   echo "<li><a href=\"builds/".$dir."/".$build."\">".$build."</a>".($i==0 ?" - Current":"")."</li>";
                                  $i++;
                                }
                              ?>
                            </ul>
                            <?php
                          }
                        ?>
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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-59805208-2', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>