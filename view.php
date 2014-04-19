<?php 
	$copyButtonStatus = (DropboxConnector::isConnected() && GdriveConnector::isConnected()) ? "" : "disabled=disabled";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Zapstitch Dropbox to GDrive File Copy Demo</title>

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
        <h3 class="text-muted">Zapstitch demo</h3>
      </div>

      <div>
      	<div class="alert" id="alert" style="display: none">
      		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      		<div id="alert-content">You are crazy...</div>
      	</div>
      	
        <p class="lead">
        	Copy your first dropbox file to google drive with ease. Simple connect to both of them
        	and press copy button.
        </p>
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
			<p style="float: right">
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
      </div aligh="center">
      
      	<div class="progress progress-striped active" style="width: 300px; margin: auto; margin-bottom: 10px; display: none" id="copy-pbar">
      	
		  <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
		    <span class="sr-only">45% Complete</span>
		    File is being copied
		  </div>
		  
		</div>
		
        <p style="text-align: center">
        	<button class="btn btn-lg btn-success" 
        			href="javascript:void(0)"
        			role="button"
        			id="btnCopyfile"
        			<?php echo $copyButtonStatus?>
        			>
        			
        			Copy file
        	</button>
        </p>
      </div>

      

      <div class="footer">
        <p>&copy; NoName till earth ends</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//getbootstrap.com/dist/js/bootstrap.min.js"></script>
    
    <script type="text/javascript">
    	$inProgress = false;
		$("#btnCopyfile").click(function(){
			$.ajax({
				url: 'action.php?action=copyFirstFile',
				dataType: 'json',
				beforeSend: function(){
					if ($inProgress == true) return false;
					$("#copy-pbar").show();
					$inProgress = true; 
					$("#btnCopyfile").attr("disabled", "disabled");
				},
				success: function(response){
					$("#alert").attr("class", "alert alert-dismissable");
					$("#alert").addClass("alert-"+response.type);
					$("#alert-content").html(response.msg);
					$("#alert").show();
					$("#copy-pbar").hide();
					$inProgress = false;
					$("#btnCopyfile").removeAttr("disabled");
				}
			})
		});
    </script>
  </body>
</html>
