<?php

$request = $_SERVER['REQUEST_URI'];
$con = mysqli_connect("localhost","root","","dux");
$response = array ();

switch ($request) {

    case '/apidux/api.php/users':
      
        if($con){
            $sql = "select * from user";
            $result = mysqli_query($con,$sql);
            if($result){
                header("Content-Type: JSON");
                $i = 0;
        
                while( $row = mysqli_fetch_assoc( $result)){
    
                    $response[$i] ['id'] = $row['id'];
                    $response[$i] ['nome'] = $row['nome'];
                    $response[$i] ['username'] = $row['username'];
                    $response[$i] ['email'] = $row['email'];
                    $response[$i] ['password'] = $row['password'];
                    $i++;
    
                }
    
    
                echo json_encode($response,JSON_PRETTY_PRINT);
            }
    
        }
        else {
            echo "Falhou a ligação com a base de dados";
        }
    
    
    
    break;

    case '/apidux/api.php/salas':

      
        if($con){
            $sql = "select * from salas";
            $result = mysqli_query($con,$sql);
            if($result){
                header("Content-Type: JSON");
                $i = 0;
        
                while( $row = mysqli_fetch_assoc( $result)){
    
                    $response[$i]['id'] = $row['id'];
                    $response[$i]['nome'] = $row['nome'];
                    $id_espaco = $row['id_espaco'];
                    
               
                    $query = "SELECT lugares FROM espaco WHERE id = $id_espaco";
                    $result2 = mysqli_query($con, $query);
                    $row2 = mysqli_fetch_assoc($result2);
                    $lugares_string = $row2['lugares'];
                    
          
                    $lugares_ids = explode(',', $lugares_string);
           
                    $lugares = array();
                    foreach ($lugares_ids as $lugar_id) {
                        $query = "SELECT ocupado FROM lugares WHERE id = $lugar_id";
                        $result3 = mysqli_query($con, $query);
                        $row3 = mysqli_fetch_assoc($result3);
                        $lugares[$lugar_id] = $row3['ocupado'];
                    }
                    
            
                    $response[$i]['lugares'] = $lugares;
                    
                    $i++;

    
                }
    
    
                echo json_encode($response,JSON_PRETTY_PRINT);
            }
    
        }
        else {
            echo "Falhou a ligação com a base de dados";
        }
    




    break;

    case '/apidux/api.php/biblioteca':

        if($con){
            $sql = "select * from biblioteca";
            $result = mysqli_query($con,$sql);
            if($result){
                header("Content-Type: JSON");
                $i = 0;
        
                while( $row = mysqli_fetch_assoc( $result)){
    
                    $response[$i]['id'] = $row['id'];
                    $id_espaco = $row['id_espaco'];
                    
               
                    $query = "SELECT lugares FROM espaco WHERE id = $id_espaco";
                    $result2 = mysqli_query($con, $query);
                    $row2 = mysqli_fetch_assoc($result2);
                    $lugares_string = $row2['lugares'];
                    
          
                    $lugares_ids = explode(',', $lugares_string);
           
                    $lugares = array();
     

                    foreach ($lugares_ids as $lugar_id) {
               
             

                        $query = "SELECT ocupado FROM lugares WHERE id = $lugar_id";
                        $result3 = mysqli_query($con, $query);
                        $row3 = mysqli_fetch_assoc($result3);
                        $lugares[$lugar_id] = $row3['ocupado'];

                       
                    }
                    
            
                    $response[$i]['lugares'] = $lugares;
                    
                    $i++;

    
                }
    
    
                echo json_encode($response,JSON_PRETTY_PRINT);
            }
    
        }
        else {
            echo "Falhou a ligação com a base de dados";
        }


    break;

    default:
    // Retorne uma resposta de erro para solicitações inválidas
    http_response_code(404);
    echo "Endpoint não encontrado.";
    break;



}
    

?>