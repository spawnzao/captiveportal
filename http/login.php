<!DOCTYPE html>
<html lang="en">
  <head>
    <title>
        Users   </title>
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

   <!-- Fancybox-->
    <script type="text/javascript" src="fancybox/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
    
    <script type="text/javascript">
    $(document).ready(function() {
    
        $(".fancybox").fancybox({
    	    openEffect  : 'none',
    	    closeEffect : 'none',
    	    iframe : {
        	preload: false
    	    }
        });
    
        $('#termo_uso').on('click', function() {
            if (this.checked) {
                $('#submit').attr("disabled", false);
            } else {
                $('#submit').attr("disabled", true);
            }
        });
   });
    
    </script>


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

              
        </div><!--/.nav-collapse -->
      </div>
    </div>
    </div>

    <div class="container-fluid">

            
            <div class="container">
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading"> <strong class="">Entrar</strong>

                </div>
                <div class="panel-body">
                    
                    <form action="/?page=login" class="form-horizontal" id="UserLoginForm" method="post" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Usuário</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                  <div class="input usuario required"><input name="UserUsername" class="form-control" placeholder="Usuario" type="usuario" id="UserUsername" required="required"/></div>                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-3 control-label">Senha</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                  <div class="input password"><input name="UserPassword" class="form-control" placeholder="Senha" type="password" id="UserPassword"/></div>                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-9">
                        	<input type="checkbox" name="termo" value="1" id="termo_uso" required="required"/> <label for="termo_uso">Li e aceito os </label>
                    		<a class="fancybox" data-fancybox-type="iframe" href="termo_de_uso.pdf" title="Termos de Uso">Termos de Uso</a>
                            </div>
                        </div>
			<div class="form-group last">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" id="submit" name="submit" class="btn btn-success btn-sm" disabled />Entrar</button>
                                <button type="reset" class="btn btn-default btn-sm">Limpar</button>
                            </div>
                        </div>
<?php
if (isset($this->msg_page))
  echo '<div id="flashMessage" class="alert alert-danger">'.$this->msg_page.'</div> ';

?>
		    </form>                                    </div>
                <div class="panel-footer text-center">Desenvolvido por <a
href="http://spawnzao.com.br">Willen (spawnzao)</a> - <a
href="http://seweb.com.br">SeWEB</a></div>
            </div>
        </div>
    </div>
</div>

    </div><!-- /.container -->
    
  </body>
</html>

