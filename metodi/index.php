<?php

    // Connessione al database
    $servername = "localhost";
    $username = "root";
    $password = "banana";
    $database = "catalogo";

    $conn = mysqli_connect($servername, $username, $password, $database);
    $tabelle = array("prodotti", "case_produttrici", "dispositivi", "sedi");
    $campi_primari = array("Numero_Serie", "Nome", "Id", "Id");

    // Verifica della connessione
    if (!$conn) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // echo $_SERVER['REQUEST_URI'];

    $array = explode('/',$_SERVER['REQUEST_URI']);
    echo "<br>";
    foreach ($array as $a) 
    {
        echo $a . "<br>";
    } 
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
            //POST RECORD
            if (count($array) == 5 && $array[4] != '' && $array[3] != '')
            {
                $id = $array[4];
                $tab;
                $pos = 0;
                foreach ($tabelle as $t) 
                {
                    if($t == $array[3])
                    {
                        $tab = $t;
                        break;
                    }
                    $pos++;
                } 
                $sql = "SELECT * FROM $tab WHERE $campi_primari[$pos] == $id";
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0)  
                {
                    echo "Valore esistente";
                } else 
                {
                    echo "Nessun risultato trovato con Id $id";
                }
            }
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

<!-- curl -v -H "Content-Type: application/json" -X POST \ -d '{"name":"your name","phonenumber":"111-111"}' http://www.example.com/details -->
