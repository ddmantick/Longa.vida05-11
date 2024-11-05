<?php

$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "longa_vida";     

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


$numero = $descricao = $valor = "";
$searchQuery = "";


$recordsPerPage = 10;


$page = isset($_GET['page']) ? $_GET['page'] : 1;
$startFrom = ($page - 1) * $recordsPerPage;


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
    $searchQuery = $_GET['search'];
}


$queryPlanos = "SELECT Numero, Descricao, Valor FROM Plano 
                WHERE Numero LIKE '%$searchQuery%' OR Descricao LIKE '%$searchQuery%' 
                LIMIT $startFrom, $recordsPerPage";

$resultPlanos = $conn->query($queryPlanos);


$totalRecordsQuery = "SELECT COUNT(*) FROM Plano WHERE Numero LIKE '%$searchQuery%' OR Descricao LIKE '%$searchQuery%'";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_array()[0];
$totalPages = ceil($totalRecords / $recordsPerPage);


$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Planos Longa Vida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-container, .message {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2, .message {
            text-align: center;
        }
        .form-container input, .form-container button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .table-container {
            margin-top: 40px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            text-decoration: none;
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
        }
        .pagination a:hover {
            background-color: #45a049;
        }
        .message.success {
            color: green;
            font-weight: bold;
        }
        .message.error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Gerenciamento de Planos Longa Vida</h1>

     
        <div class="form-container">
            <h2>Pesquisar Planos</h2>
            <form method="GET">
                <input type="text" name="search" value="<?php echo $searchQuery; ?>" placeholder="Buscar por Número ou Descrição do Plano">
                <button type="submit">Pesquisar</button>
            </form>
        </div>

       
        <div class="table-container">
            <h2>Planos Cadastrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultPlanos->num_rows > 0) {
                        while($row = $resultPlanos->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["Numero"] . "</td>
                                    <td>" . $row["Descricao"] . "</td>
                                    <td>R$ " . number_format($row["Valor"], 2, ',', '.') . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Nenhum plano encontrado</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

       
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href='?page=$i&search=$searchQuery'>$i</a>";
            }
            ?>
        </div>
    </div>

</body>
</html>
