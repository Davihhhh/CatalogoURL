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
    
    /*
    foreach ($array as $a) 
    {
        echo $a . "<br>";
    }
    */

    $response = "";
    $code = 404;

    try
    {
        switch ($_SERVER['REQUEST_METHOD']) 
        {
            case "GET":
                //GET TABELLA
                if(count($array) == 3 && $array[2] != '')
                {
                    $tab = $array[2];
                    $sql = "SELECT * FROM $tab";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0)  
                    {
                        $response .= "[";

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $response .= json_encode($row) . ",";
                            }
                            $response = rtrim($response, ",");
                        }
                        $response .= "]";
                        $code = 200;
                    } 
                    else {
                        $code = 404;
                        $response = "Nessun risultato";
                    }
                }
                //GET VALORE
                else if (count($array) == 4 && $array[3] != '' && $array[2] != '')
                {
                    $tab = $array[2];
                    $id = $array[3];
                    $sql = "SELECT * FROM $tab WHERE Id = $id";
                    
                    $result = mysqli_query($conn, $sql);
        
                    if (mysqli_num_rows($result) > 0)  
                    {
                        $row = $result->fetch_assoc();
                        $response = json_encode($row);
                        $code = 200;
                    }
                    else {
                        $code = 404;
                        $response = "Nessun risultato";
                    }
                }
                break;
            case "POST":  
                //CREATE RECORD
                if (count($array) == 5 && $array[4] != '' && $array[3] != '')
                {
                    $id = $array[4];
                    $tab = "";
                    $pos = 0;
                    $campi = array();
                    foreach ($tabelle as $t) 
                    {
                        if($t == $array[3])
                        {
                            $tab = $t;
                            $sql = "SELECT TOP 1 * FROM $tab";
                        
                            if ($conn->query($sql) === TRUE) 
                            {
                                while ($fieldinfo = mysqli_fetch_field($result)) 
                                {
                                    array_push($campi, $fieldinfo);
                                }
                            }
                            break;
                        }
                        $pos++;
                    } 
                    if($tab == "")
                    {
                        $response = "Tabella inesistente";
                    }
                    else
                    {
                        $sql = "SELECT * FROM $tab WHERE $campi[0] == $id";
                        $result = mysqli_query($conn, $sql);
                        
                        if (mysqli_num_rows($result) > 0)  
                        {
                            $response = "Valore esistente";
                        } else 
                        {
                            $valori = array();
                            foreach ($campi as $campo) {
                                array_push($valori, $_POST[$campo]);
                            }   
                            if (count($campi) == count($valori)) {
        
                                $campi_string = implode(", ", $campi);                  
                                $valori_string = "'" . implode("', '", $valori) . "'";
        
                                $sql = "INSERT INTO $tab ($campi_string) VALUES ($valori_string)";
                            }
                        }
                    }
                }
                break;
            case "DELETE":
                //DELETE RECORD
                if (count($array) == 5 && $array[4] != '' && $array[3] != '')
                {
                    $tab = $array[3];
                    $id = $array[4];
                    $sql = "SELECT * FROM $tab WHERE Id = '$id'";
                    
                    $result = mysqli_query($conn, $sql);
        
                    if (mysqli_num_rows($result) > 0)  
                    {
                        $row = $result->fetch_assoc();
                        $response = json_encode($row);
                        $sql = "DELETE FROM $tab WHERE Id = '$id'";
                        if ($conn->query($sql) === TRUE) 
                    {
                        $response = "Record eliminato con successo";
                    } else 
                    {
                        $response = "Errore durante l'eliminazione del record: " . $conn->error;
                    }
                    }
                }
                break;
            case "PUT":
                //UPDATE RECORD
                if (count($array) == 5 && $array[4] != '' && $array[3] != '')
                {
                    $valori = explode(';', $array[5]);
                    $id = $valori[0];
                    $pos = 0;
                    $campi = array();
                    foreach ($tabelle as $t) 
                    {
                        if($t == $array[3])
                        {
                            $tab = $t;
                            $sql = "SELECT TOP 1 * FROM $tab";
                        
                            if ($conn->query($sql) === TRUE) 
                            {
                                while ($fieldinfo = mysqli_fetch_field($result)) 
                                {
                                    array_push($campi, $fieldinfo);
                                }
                            }
                            break;
                        }
                        $pos++;
                    } 
                    if($tab == "")
                    {
                        $response = "Tabella inesistente";
                    }
                    else
                    {
                        $sql = "SELECT * FROM $tab WHERE $campi[0] == $id";
                        $result = mysqli_query($conn, $sql);
                        
                        if (mysqli_num_rows($result) > 0)  
                        {
                            $query = "";
                            $cont = 0;
                            foreach ($valori as $valore) {
                                $query += $campi[cont] . '=' . $valore . ',';
                            }
                            $query = rtrim($query, ",");
                            $sql = "UPDATE $tab
                            SET $query
                            WHERE $campi[0] = $id";
                            
                            $result = mysqli_query($conn, $sql);
                        } else 
                        {
                            $response = "Valore inesistente";
                        }
                    }
                }
                else 
                    break;
            case "OPTIONS":
                header("Access-Control-Allow-Origin: *");
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
                header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

                $response = "Richiesta approvata";
                $code = 200;
                break;
            default:
                $code = 405;
                break;
        }
        if($response == "")
        {
            $response = "Nessun risultato";
            $code = 404;
        }  
        else 
            $code = 200;
        http_response_code($code);
        echo $response;
    } catch(Exception $e){ http_response_code(503); echo $e; }
      
    $conn->close();

    //curl -v -H "Content-Type: application/json" -X GET localhost/metodi/
?>
