<?php 

        class MCrypt
        {
                private $iv = 'fedcba9876543210'; #Same as in JAVA
                private $key = '0123456789abcdef'; #Same as in JAVA


                function __construct()
                {
                }

                /* CRIPTOGRAFAR - NAO IRA UTILIZAR
                function encrypt($str) {

                  //$key = $this->hex2bin($key);    
                  $iv = $this->iv;

                  $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);

                  mcrypt_generic_init($td, $this->key, $iv);
                  $encrypted = mcrypt_generic($td, $str);

                  mcrypt_generic_deinit($td);
                  mcrypt_module_close($td);

                  return bin2hex($encrypted);
                }
                */

                function decrypt($code) {
                  //$key = $this->hex2bin($key);
                  $code = $this->hex2bin($code);
                  $iv = $this->iv;

                  $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);

                  mcrypt_generic_init($td, $this->key, $iv);
                  $decrypted = mdecrypt_generic($td, $code);

                  mcrypt_generic_deinit($td);
                  mcrypt_module_close($td);

                  return utf8_encode(trim($decrypted));
                }

                protected function hex2bin($hexdata) {
                  $bindata = '';

                  for ($i = 0; $i < strlen($hexdata); $i += 2) {
                        $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
                  }
                  return $bindata;
                }

        }

  $con =mysqli_connect("localhost","root","","bd_login");
  
  $sql = "select mensagem from MsgEncrypted where id='1';";
  $result = mysqli_query($con,$sql);

  $crypto = new MCrypt;

   while ($row = $result->fetch_assoc()) {
    $msgCripto = $row['mensagem'];
    echo " Mensagem Criptografada = " . $msgCripto . "\n";
  }

  echo '<br />';
  echo '<br />';

  echo '<form action="" method="post">
          <input type="submit" value="Discriptografar" name="botao">
      </form>';

  if(isset($_POST["botao"])){

    $msgDescrypted = $crypto->decrypt($msgCripto);

    echo "Mensagem Discriptografada: ".$msgDescrypted;



  }



  echo '<br />';
  echo '<br />';

  echo '<br />';
  echo '<br />';


?>