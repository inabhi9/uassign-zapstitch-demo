

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Narrow Jumbotron Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
        <h3 class="text-muted">Project name</h3>
      </div>

      <div class="jumbotron">
        <h1>Jumbotron heading</h1>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn btn-lg btn-success" href="#" role="button">Copy file</a></p>
      </div>

      <div class="row marketing">
        <div class="col-lg-6">
			<p>
				<?php if (DropboxConnector::isConnected() == False) { ?>
					<a role="button" class="btn btn-lg btn-default" href="<?php echo $ddConnectUrl?>">
						<img width="36" src="https://dt8kf6553cww8.cloudfront.net/static/images/icons/blue_dropbox_glyph-vflJ8-C5d.png">
						Connect to Dropbox
					</a>
				<?php } else {?>
					<a role="button" class="btn btn-lg btn-default" href="<?php echo $ddDisconnectUrl?>">
						<img width="36" src="https://dt8kf6553cww8.cloudfront.net/static/images/icons/blue_dropbox_glyph-vflJ8-C5d.png">
						Disconnect to Dropbox
					</a>
				<?php } ?>
			</p>
        </div>

        <div class="col-lg-6">
			<p>
				<?php if (GdriveConnector::isConnected() == False) { ?>
					<a role="button" class="btn btn-lg btn-default" href="<?php echo $gdConnectUrl?>">
						<img width="36" src="https://developers.google.com/drive/images/drive_icon.png">
						Connect to Drive
					</a>
				<?php } else {?>
					<a role="button" class="btn btn-lg btn-default" href="<?php echo $gdDisconnectUrl?>">
						<img width="36" src="https://developers.google.com/drive/images/drive_icon.png">
						Disconnect to Drive
					</a>
				<?php } ?>
			</p>
        </div>
      </div>

      <div class="footer">
        <p>&copy; Company 2014</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
