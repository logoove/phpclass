<?php
/**
 * @param $data 私钥加密需要公钥解密
 * @param  $pri_key 私钥
 * @return string
 */
function privateEncode($data,$pri_key){
    $pri_key = openssl_pkey_get_private($pri_key);
    openssl_private_encrypt($data, $encrypted, $pri_key);
    $crypted = base64_encode($encrypted);
    return $crypted;
}

/**
 * @param $data 公钥解密需要公钥
 * @param $pub_key 公钥
 * @return string
 */
function publicDecode($data,$pub_key){
    $pub_key = openssl_pkey_get_public($pub_key);
    openssl_public_decrypt(base64_decode($data),$de,$pub_key);
    return $de;
}

/**
 * @param $data 公钥加密
 * @param $pub_key 公钥
 * @return string
 */
function publicEncode($data,$pub_key){
    $pub_key = openssl_pkey_get_public($pub_key);
    openssl_public_encrypt($data, $en, $pub_key);
    return base64_encode($en);
}
/**
 * @param $data 私钥解密
 * @param $pri_key 私钥
 * @return string
 */
function privateDecode($data,$pri_key){
    $pri_key = openssl_pkey_get_private($pri_key);
    openssl_private_decrypt(base64_decode($data), $de, $pri_key);
    return $de;
}
$pub  = file_get_contents("rsapublickey.pem");
$pri  = file_get_contents('pkcs8rsaprivate_key.pem');
$str = 'a我1你w';
$data = privateencode($str,$pri);
echo "私钥加密: ".$data . '<br><br>';
$decode = publicdecode($data,$pub);
echo "公钥解密: ".$decode . '<br><br>';
$pdata =publicEncode($str,$pub);
echo "公钥加密: ".$pdata . '<br><br>';
$pdecode = privatedecode('sZN4eWWTVCIVF3k36Ge5WBX8RHdni8QdrhKTVY5Z91OCUJOLX8sAAeYc56cE6ksPccR71aSnemwKzlnywV70ToOQ/Fx0jCvt9RG5LyTui8XViiU31YA3Rm+JcghdauoDa+7ojqVpk6FqESW2YfXPYZuvCqJJgT+1TppeTU34zns=',$pri);
echo "私钥解密可解js公钥加密: ".$pdecode . '<br>';

?>
<script src="jsencrypt.min.js"></script>
<script type="text/javascript">
let pub = new JSEncrypt();
pub.setPublicKey("-----BEGIN PUBLIC KEY-----\n" +
    "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8C7KDJCJqH5H9O3+nzCCjYcWk\n" +
    "dXyOziFXInB4REu8T6oLh3m/PIbkvgYaWgKy/JxPqbrDKNhBfDcvan0c4lYuBcBV\n" +
    "jlHJquuG7Rl/aF4kKaaVtfu042U1fYk1CJvo56mEg+NzMOD/Uroxifp7x5MC4H0V\n" +
    "UsMfXtNsCE9JfW44MQIDAQAB\n" +
    "-----END PUBLIC KEY-----");
document.write("<br><br>公钥加密:"+pub.encrypt('测试Rsa加密信息'));
</script>
