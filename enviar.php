<?php
if(isset($_POST['email'])) {
 
    $email_to = "hernanlopez28902dd@gmail.com";
    $email_subject = "Mensaje desde el formulario de contacto";
 
    function died($error) {
        // Si hay algún error en el formulario, muestra el mensaje de error
        echo "Lo sentimos, pero se encontraron errores en el formulario que has enviado. ";
        echo "Estos son los errores que se encontraron:<br /><br />";
        echo $error."<br /><br />";
        echo "Por favor, corrige estos errores.<br /><br />";
        die();
    }
 
    // Validación de los datos del formulario
    if(!isset($_POST['nombre']) ||
        !isset($_POST['email']) ||
        !isset($_POST['mensaje'])) {
        died('Lo sentimos, pero hay un problema con los datos que has enviado.');       
    }
 
    $nombre = $_POST['nombre']; // Requerido
    $email_from = $_POST['email']; // Requerido
    $mensaje = $_POST['mensaje']; // Requerido
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'El correo electrónico que has ingresado no es válido.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$nombre)) {
    $error_message .= 'El nombre que has ingresado no es válido.<br />';
  }
  if(strlen($mensaje) < 2) {
    $error_message .= 'El mensaje que has ingresado no es válido.<br />';
  }
  if(strlen($error_message) > 0) {
    died($error_message);
  }
    $email_message = "Detalles del formulario de contacto:\n\n";
 
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
    $email_message .= "Nombre: ".clean_string($nombre)."\n";
    $email_message .= "Correo electrónico: ".clean_string($email_from)."\n";
    $email_message .= "Mensaje: ".clean_string($mensaje)."\n";
 
//Encabezados
$headers = "From: $email_from\r\n".
"Reply-To: $email_from\r\n" .
"X-Mailer: PHP/" . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  
?>
 
<!-- Mensaje de confirmación -->
Gracias! Nos pondremos en contacto contigo a la brevedad posible.
 
<?php
