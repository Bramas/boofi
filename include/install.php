<?php

if(!empty($_POST['privateKey']) && $_POST['password'] === $_POST['password2'])
{

$privateKey = stripslashes($_POST['privateKey']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT, ['salt' => $privateKey, 'cost' => 12]);

$data = "<?php

DEFINE('PRIVATE_KEY', '".$privateKey."');

date_default_timezone_set('Europe/Paris');

\Boofi\Config::addFolders(array(
	'".stripslashes($_POST['folderName'])."' => '".stripslashes($_POST['folderPath'])."'
	));

// password: admin
\Boofi\Authenticator::addUser('".stripslashes($_POST['login'])."', '".$password."');

";

if(!file_put_contents ( 'config.php', $data))
{

	echo 'unable to save config file. Please create config.php with the following content:<br/><br/>';
	echo $data;
	exit();
}
header("Location: index.php");
exit();

}
else
{

$defaultPrivateKey = bin2hex(openssl_random_pseudo_bytes(64));
?>
<form method="POST">
<div class="form-group">
    <label for="inputPrivateKey">Private Key</label>
    <input type="text" name="privateKey" class="form-control" id="inputPrivateKey" value="<?php echo $defaultPrivateKey; ?>">
  </div>
<div class="form-group">
    <label for="inputLogin">Login</label>
    <input type="text" name="login" class="form-control" id="inputLogin" placeholder="Login">
  </div>
  <div class="form-group">
    <label for="inputPassword">Password</label>
    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="inputPassword2">Password Again</label>
    <input type="password" name="password2" class="form-control" id="inputPassword2" placeholder="Password Again">
  </div>
  <div class="form-group">
    <label for="inputFolderName">Folder Name</label>
    <input type="text" name="folderName" class="form-control" id="inputFolderName" placeholder="">
  </div>
  <div class="form-group">
    <label for="inputFolderPath">Folder Path</label>
    <input type="text" name="folderPath" class="form-control" id="inputFolderPath" placeholder="">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
<?php

}
?>


