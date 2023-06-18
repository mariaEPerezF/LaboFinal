<?php

    function test_input($data) {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;

    }


    if ($_POST) {

        $servername="localhost";
        $username="root";
        $password="";
        $dbname="cursosql";

        //Conexion a la BD
        $conn=new mysqli($servername,$username,$password,$dbname);
        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }

        //Validaciones
        if (isset($_POST['Enviar'])) {

        $nombreErr= "";
        $primerApellidoErr="";
        $segundoApellidoErr= "";
        $emailErr= "";
        $loginErr= "";
        $passwordErr= "";
        $generalErr="";
        

        $nombre= $_POST['nombre'];
        $primerApellido= $_POST['primerApellido'];
        $segundoApellido= $_POST['segundoApellido'];
        $email= $_POST['email'];
        $login= $_POST['login'];
        $password= $_POST['password'];
        $respuesta="";
        $usuariosRegistrados=[];



        $findSql= "SELECT email FROM usuario WHERE email = '$email'";

        $result = $conn->query($findSql);

        if ($result->num_rows > 0) {

                $emailErr = "Este correo ya esta registrado en el sistema";

        
            } else {
                
            $sql= "INSERT INTO usuario (nombre, primerapellido, segundoapellido, email, login, password )
            VALUES('$nombre', '$primerApellido', '$segundoApellido', '$email', '$login' , '$password')";
    
            if($conn->query($sql) === TRUE){

                $respuesta = "Registro completado";

            }
            else{

                $respuesta = "Error: " . $sql . "<br>" . $conn->error ;
            }

            $sql = "SELECT * FROM usuario";

            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {

                $usuariosRegistrados ="<table>";

                $usuariosRegistrados = $usuariosRegistrados . "<tr><th>Nombre</th><th>Primer apellido</th><th>Email</th></tr>";
            
                // Obtener los datos 
                while ($fila = mysqli_fetch_assoc($result)) {

                    // Recuperar los valores del nombre
                    $nombre     = $fila['NOMBRE'];
                    // Recuperar los valores del spellido
                    $apellido   = $fila['PRIMERAPELLIDO'];
                    // Recuperar los valores del email
                    $email      = $fila['EMAIL'];
                    $usuariosRegistrados= $usuariosRegistrados . "<tr><td>" . $nombre . "</td><td>" . $apellido .  "</td><td>" . $email . "</td></tr>";
                }
            
                $usuariosRegistrados= $usuariosRegistrados . "</table>";

                mysqli_free_result($result);
            } 
                
        }

      } 

      include "formulario.html";
      $conn-> close();
    }



    

?>



