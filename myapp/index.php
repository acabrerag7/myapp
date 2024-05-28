<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <style>
        /* Estilos CSS para el encabezado */
        .header {
            text-align: center;
            margin-bottom: 0px;
        }
    </style>
<head>

  </head>

  <title>Iniciar sesión o registrarse</title>
  <style>
body {
  
  background-image: url('images/fondo2.jpg');
  background-size: cover; /* Cubre todo el espacio disponible sin perder proporciones */
  background-position: center; /* Centra la imagen en el elemento */
  background-repeat: no-repeat; /* Evita que la imagen se repita */
  box-sizing: border-box;
  font-family: "Noto Sans JP", sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  color: #333;
  min-height: 100vh; /* Corregido de 10vh a 100vh para que cubra toda la altura de la vista */
}

    .container {
      max-width: 400px;
      margin: 0rem auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    
    h1 {
      color: #333;
      margin: 2rem auto;
    }

    
    .button-link {
      display: inline-block;
      margin-top: 0.5rem;
      padding: 10px 10px;
      background: linear-gradient(50deg, rgba(140, 43, 231, 1) 25%, rgba(61, 1, 245, 1) 80%);
      color: #ffffff;
      text-decoration: none;
      border-radius: 25px;
      transition: background-color 0.3s ease;
    }

    .button-link:hover {
      background-color: #0056b3;
    }

    
    p {
      line-height: 1.6;
    }
  </style>
</head>
<body>
  <main class="container">
    <header>
      <h1>Bienvenido</h1>
    </header>
    <section aria-labelledby="options">
      <h2 id="options">Opciones</h2>
      <p>¿Ya tienes una cuenta? <a href="login.php" class="button-link">Inicia sesión aquí</a></p>
      <p>¿Eres nuevo? <a href="registrar.php" class="button-link">Regístrate aquí</a></p>
    </section>
  </main>
  </body>



