<?php

/**
 * Class Place
 *
 * Clase para gestionar el consumo del webservice Place to Pay
 *
 * @package jcrojasv\PruebaNubelo
 *
 */
class PlaceToPay
{

    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $tranKey;
    /**
     * @var string
     */
    private $login;
    /**
     * @var object
     */
    private $conexion;
    /**
     * @var false|string
     */
    public $seed;
    /**
     * @var array
     */
    private $auth;


    public function __construct($wsdl, $tranKey, $id)
    {
        $this->url = $wsdl;
        $this->login = $id;
        $this->seed = date('c');
        $this->tranKey = sha1($this->seed . $tranKey);
        $this->setConect();
    }

    /**
     * Permite conectarse al webservice de Place to pay
     *
     * @return bool|string
     */
    private function setConect()
    {
        try {

            $this->conexion = new SoapClient($this->url, ['trace' => true, 'cache_wsdl' => WSDL_CACHE_MEMORY]);

            $this->setAuth();

            //var_dump($this->conexion->__getFunctions());

            return true;

        } catch (SoapFault $e) {

           return $e->getMessage();

        }

    }

    /**
     * Setea la propiedad setAuth con los datos obtenidos en el constructor
     * esta estructura de datos es necesario para ciertos metodos del webservice
     *
     */
    private function setAuth()
    {

        $this->auth = array(
            'login'      => $this->login,
            'tranKey'    => $this->tranKey,
            'seed'       => $this->seed,
            'additional' => '');
    }

    /**
     * Obtiene el listado de bancos al consumir el servicio getBankList
     * en caso de fallar retorna un mensaje indicando el error
     *
     * @return array
     */
    private function getServiceBankList()
    {
        try {

            return $this->conexion->getBankList(array('auth' => $this->auth));

        } catch (SoapFault $e) {

            return array('code' => 'ERROR','message'=>$e->getMessage());

        }


    }

    /**
     * Se supone que en este metodo se realice la lectura del cache en caso de
     * que yase haya consumido el servicio en el dia
     *
     * @return array
     */
    private function getBankList()
    {
        //Realizo la lectura del cache retorno el arreglo de bancos
    }

    /**
     * Permite verificar si se ha consumido o no el servicio getBankList
     * para devolver el array del listado de bancos
     * @return array|string
     */
    public function getCacheBancos()
    {
        /*
        * Esta variable me sirve para probar, emula que ya se ha consumido el servicio
        * getBankList, que debe ser solo una vez por dia   
        * aqui quizas haria una consulta a la bd para determinar si ya se consumioo el servicio,
        * seria un metodo de esta clase que revisaria lo anteriormente dicho,
        * para casos de ejemplo seteo la variable en falso para que tome el listado desde el webservice
        */
        //

        $servicioConsumido = false;

        if ($servicioConsumido)
            $arrayBancos = $this->getBankList();
        else
            $arrayBancos = $this->getServiceBankList();


        return $arrayBancos;

    }

    /**
     * Metodo que consume el servicio createTransaction
     * si ha podido crear la transaccion devuelve un objeto con el resultado de la transaccion
     * especificados en el manual, si no devuelve un array con el mensaje de error o con el codigo de
     * la respuesta
     *
     * @param $arrayRequest
     * @return array
     */
    public function createTransaction($arrayRequest)
    {
        try {

            $response = $this->conexion->createTransaction(array('auth' => $this->auth, 'transaction' => $arrayRequest));

            if ($response->createTransactionResult->returnCode == 'SUCCESS')
            {

                $this->setTransaction($response->createTransactionResult);

                return $response->createTransactionResult;

            } else {

                return array('code'=>'ERROR','message'=>$response->createTransactionResult->returnCode);

            }
        } catch (SoapFault $e) {

            return array('code'=>'ERROR','message'=>$e->getMessage());

        }

    }

    /**
     * Metodo que simula guardar en la base de datos la informacion de la transaccion
     *
     * @param $objTransaction
     *
     * @return boolean | Exception
     *
     */
    public function setTransaction($objTransaction)
    {
        //Simulacion de guardar la info en un modelo

        /**
         *  $objTabla = new Modelo();
         *
         * try {
         *
         *   $objTabla->create($objTransaction);
         *
         *   return true;
         *
         * } catch (ExceptionBd $e) {
         *
         *  return $e;
         * }
         *
         */

        //Creo un cookie con el id de la transaccion
        setcookie('tranId',$objTransaction->transactionID);
        //cookie para controlar el tiempo de conuslta a las transacciones
        setcookie('timeToReload',time() + 720);

        return true;

    }

    /**
     * Metodo que verifica el estado de la transaccion
     *
     * @return object | array
     *
     */

    public function getTransaction()
    {
        try{


            if(isset($_COOKIE['timeToReload'])) {

                $tranID = $_COOKIE['tranId'];

                return $this->conexion->getTransactionInformation(array('auth' => $this->auth),$tranID);


            } else {

                return array('code'=>'ERROR','message'=>'Ha pasado mucho tiempo de espera, 
                no hemos recibido una respuesta de su banco, intente de nuevo');

            }


        } catch(SoapFault $e) {

            return array('code'=>'ERROR','message'=>$e->getMessage());

        }
    }

}
