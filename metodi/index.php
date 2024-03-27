<?php

    // Connessione al database
    $servername = "localhost";
    $username = "root";
    $password = "banana";
    $database = "catalogo";

    $conn = mysqli_connect($servername, $username, $password, $database);
    $tabelle = array("prodotti", "case_produttrici", "dispositivi", "sedi");

    // Verifica della connessione
    if (!$conn) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // echo $_SERVER['REQUEST_URI'];

    $array = explode('/',$_SERVER['REQUEST_URI']);
    // echo "<br>";
    // foreach ($array as $a) 
    // {
    //     echo $a . "<br>";
    // } 
    switch ($_SERVER['REQUEST_METHOD']) 
    {
        case "GET":
            //GET ALL
            if (count($array) == 4 && $array[3] == '')
            {
                $sql = "";
                foreach ($tabelle as $t) 
                {
                    $sql = "SELECT * FROM $t";
                    $result = mysqli_query($conn, $sql);
    
                    if (mysqli_num_rows($result) > 0)  
                    {
                        while ($row = $result->fetch_assoc()) 
                        {
                            echo json_encode($row) . "<br>";
                        }
                    } else {
                        echo "Nessuna tabella chiamata così";
                    }
                    
                } 
            }
            //GET TABELLA
            else if(count($array) == 4 && $array[3] != '')
            {
                $sql = "SELECT * FROM $array[3]";
                $result = mysqli_query($conn, $sql);
            
                if (mysqli_num_rows($result) > 0) 
                {
                    while ($row = $result->fetch_assoc()) 
                    {
                        echo json_encode($row) . "<br>";
                    }
                } else {
                    echo "Nessun risultato trovato nella tabella.";
                }
            }
            //GET VALORE
            else if (count($array) == 5 && $array[4] != '' && $array[3] != '')
            {
                $id = $array[4];
                $sql = "SELECT * FROM $array[3] WHERE Id = $id";
                
                $result = mysqli_query($conn, $sql);
    
                if (mysqli_num_rows($result) > 0)  
                {
                    $row = $result->fetch_assoc();
                    echo json_encode($row);
                } else {
                    echo "Nessun risultato trovato con Id $id";
                }
            }
            break;
        case "POST":
            echo "Today is Tuesday";
            break;
        case "DELETE":
            echo "Today is Wednesday";
            break;
        case "PUT":
            break;
        default:
            echo "Metodo non consentito";
    }

    $conn->close();

?>