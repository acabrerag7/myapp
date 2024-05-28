<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña Cambiada</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    button {
  padding: 15px 30px; /* Ajustado el padding para un aspecto más equilibrado */
  background: linear-gradient(50deg, rgba(140, 43, 231, 1) 25%, rgba(61, 1, 245, 1) 80%);
  text-transform: uppercase;
  font-size: 16px; /* Aumentado ligeramente el tamaño de la fuente */
  cursor: pointer;
  border: none; /* Eliminado el borde para un aspecto más limpio */
  border-radius: 25px; /* Ajustado el radio del borde */
  transition: background-color 0.3s ease; /* Añadida una transición suave para el cambio de color de fondo */
  color: white; /* Color del texto en blanco */
  display: block; /* Cambiado a bloque para centrar */
  margin: 0 auto; /* Margen automático para centrar horizontalmente */
  font-family: "Noto Sans JP", sans-serif; /* Cambiado a una fuente específica */
}
</style>

<body>


<div class="container"> 
<form >    
<?php
        echo "<h1>¡Su Contraseña Ha Sido Cambiada!</h1>";
    ?>

    <p>Volverás a la página de Inicio en:  <span id="countdown">10</span> segundos.</p>
    <button onclick="returnToLogin()">Volver a La Página de Inicio</button>
</form>   
</div>
</body>    

    

    <script>
        // Función para iniciar el contador regresivo
        function startCountdown() {
            var seconds = 10;
            var countdownElement = document.getElementById("countdown");

            var countdownInterval = setInterval(function() {
                seconds--;
                countdownElement.textContent = seconds;

                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    // Redireccionar al login cuando el contador llegue a cero
                    window.location.href = "login.php";
                }
            }, 1000);
        }

        // Iniciar el contador cuando la página se cargue
        window.onload = startCountdown;

        // Función para redireccionar al login cuando se haga clic en el botón
        function returnToLogin() {
            window.location.href = "login.php";
        }
    </script>
</body>
</html>
