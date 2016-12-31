<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="es">
<!--<![endif]-->
	<head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <title>Rappi Backend</title>
            <link rel="stylesheet" href="css/vendor/bootstrap.min.css">
            <link rel="stylesheet" href="css/main.css">
            <script>
                window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
            </script>
	</head>
	<body>
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                  <div class="navbar-header">
                      <a href="#" class="navbar-brand">Rappi Backend</a>
                  </div>
                  <div class="navbar-collapse collapse" id="navbar-main">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Mercedes Rodríguez</a></li>
                    </ul>
                  </div>
                </div>
            </div>
            
            <div class="container main-container">
                <div class="row">
                    <form id="form-archivo" action="home" method="post" role="form" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                            <div class="form-group">
                                <label>Seleccione el archivo con la data de entrada (.txt)</label>
                                <div class="input-group">
                                    <input id="archivoEntrada" type="file" class="form-control" name="entrada" />
                                    <span class="input-group-btn">
                                      <button type="submit" class="btn btn-primary">Enviar</button>
                                    </span>
                                  </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-6 col-md-offset-3">
                        <h4>Respuesta:</h4>
                        <div class="respuesta-content">
                            <?php if(isset($status)){?>
                                <?php if($status == 1){ ?>
                                    <?php foreach ($respuesta as $operacion) { ?>
                                        <?php foreach ($operacion as $value) { ?>
                                            <strong><?=$value?></strong><br>
                                       <?php } ?>
                                    <?php } ?>                    
                                <?php }else{?>
                                   <strong><?=$mensaje?></strong>
                                <?php }?>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Scripts -->
            <script type="text/javascript" src="js/vendor/bootstrap.min.js"></script>
	</body>
</html>