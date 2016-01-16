
<!DOCTYPE html>
<html lang="en">
  <head>
    <title> Captive Portal </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="/favicon.ico" type="image/x-icon" rel="icon" /><link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="/css/morris.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
    <script src="/js/jquery-1.11.1.min.js"></script>
    
    <script src="/js/bootstrap.min.js"></script>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        body{ padding: 70px 0px; }
    </style>

  </head>

  <body>

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"> <img class="img" src="/img/logo.png"> Captive Portal </a>
        </div>  
        <div class="collapse navbar-collapse">
                  </ul>

	<ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $user; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="/?page=logoff"><i class="fa fa-fw fa-power-off"></i>Sair</a>
                        </li>
                    </ul>
                </li>
      	  </ul>
        

      
        </div><!--/.nav-collapse -->
      </div>
    </div>
    </div>

    <div class="container-fluid">

            
            <div class="container">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 text-center">
<?php echo $user; ?> já está logado!
        </div>
    </div>
</div>

    </div><!-- /.container -->
    
  </body>
</html>
