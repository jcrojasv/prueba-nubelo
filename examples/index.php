<?php
   require("../src/PlaceToPay.php");

    include("datosPrueba.php");
    /*
     * Clase que tiene info de la persona, en este ejemplo lleno los datos con un array
     * se supone que viene de una base de datos
     */
    include("Person.php");
        
    $pagador = new Person($arrayPagador);
           
    $webService = new PlaceToPay('https://test.placetopay.com/soap/pse/?wsdl','024h1IlD','6dd490faf9cb87a9862245da41170ff2');

    $arrayBancos = $webService->getCacheBancos();

    if(array_key_exists('code',$arrayBancos))
    {
        $error = true;
        $message = $arrayBancos['message'];
    } else {
       $error = false;

    }
      
    
    if(!empty($_REQUEST)){
        
        $arrayTransaccion = array(
            'bankCode'         => $_REQUEST['bankCode'],
            'bankInterface'    => $_REQUEST['bankInterface'],
            'returnURL'        => 'http://localhost/prueba-nubelo/examples/getTransaction.php',
            'reference'        => $webService->seed,
            'description'      => $_REQUEST['description'],
            'language'         => 'ES',
            'currency'         => 'COP',
            'totalAmount'      => $_REQUEST['totalAmount'],
            'taxAmount'        => 0,
            'devolutionBase'   => 0,
            'payer'            => $pagador,
            'buyer'            => $pagador,
            'shipping'         => $pagador,
            'ipAddress'        => $ipAddress,
            'userAgent'        => $userAgent,
            'additionalData'   => null,
        );
        //LLamar al metodo crear transaccion
        $respuesta = $webService->createTransaction($arrayTransaccion);

    }
            
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        
    </head>
    <body>
    <style>
      body {
        margin-top: 60px;
      }
    </style>

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Prueba Nubelo / Place to Pay</a>

        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Pagar</a></li>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
        
        <?php if($error) : ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong> <?php echo $message ?>
        </div>
        <?php endif ?>
        
        <h2>Formulario de pago</h2>
        <form class="form-horizontal" role="form" action="index.php" method="post">
          <div class="form-group">
              <label for="cliente" class="col-lg-2 control-label">Sr:</label>
              <div class="col-lg-10">
                  <?php echo $pagador->getFirstName(). ', '.$pagador->getLastName()?>
              </div>
          </div>
          <div class="form-group">
            <label for="banco" class="col-lg-2 control-label">Seleccione el banco</label>
            <div class="col-lg-10">
                <select class="form-control" id="bankCode" name="bankCode">
                    <?php
                      if(!$error) {
                      foreach($arrayBancos as $bancos){
                          foreach ($bancos as $banco){
                              foreach ($banco as $detalle)
                                printf("<option value='%s'>%s</option>",$detalle->bankCode,$detalle->bankName); 
                          }
                      }
                      }
                    ?>
                </select>
            </div>
          </div>
          
          <div class="form-group">
             
            <label for="ejemplo_password_3" class="col-lg-2 control-label"> Interfaz</label>
            <div class="col-lg-10">
              <label class="radio-inline">
                  <input type="radio" id="bankInterface" name="bankInterface" id="bankInterface" value="0" checked> Personas
              </label>
                
              <label class="radio-inline">
                <input type="radio" id="bankInterface" name="bankInterface" id="bankInterface" value="1"> Empresas
              </label>

            </div>  
          </div>
            
          <div class="form-group">
            <label for="Monto" class="col-lg-2 control-label">Monto:</label>
            <div class="col-lg-10">
             <input type="input" class="form-control" name="totalAmount" id="totalAmount" placeholder="indique el monto">
            </div>
          </div>
            
          
            
         <div class="form-group">
             
            <label for="descripcion" class="col-lg-2 control-label"> Descripci&oacute;n</label>
          
            <div class="col-lg-10">
                <textarea class="form-control" id="description" name="description"></textarea>    
            </div>  
          </div>
  
          <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
              <button type="submit" class="btn btn-default">Procesar</button>
            </div>
          </div>
        </form>
    </div><!-- /.container -->
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    
    <?php if(is_object($respuesta)): ?>
    <script type="text/javascript">
    
       var url = "<?php echo $respuesta->bankURL?>"
       window.open(url, '_blank');
     
    </script>

    <?php endif; ?>
    </body>
</html>


