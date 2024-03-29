<?php
    require 'C:/xampp/htdocs/Elaborato/GestionalePolaris/config.php';
    require 'C:/xampp/htdocs/Elaborato/GestionalePolaris/verifica_session.php';

    if (!$_SESSION['ruolo']){
        header("Location: $GLOBALS[domain_login]");
        exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Account</title>

</head>
<body>
    
    <a href="<?php echo $GLOBALS['domain_home']?>"><button>Torna indietro</button></a>

    <!-- pulsante per l'inserimento di un nuovo Allergene -->
    <h3>Inserisci un nuovo Account</h3>
    <form action="inserimento_Account.php" method="POST">
        nome<input maxlength="30" type="text" name="nome" required/>
        password<input type="password" inpupt maxlength="30"  name="pwd" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{6,}$" required/>
        conferma password<input type="password" inpupt maxlength="30"  name="pwd_verifica" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=\S+$).{6,}$" required/>
        Amministratore?
            <input type="checkbox" value="true" name="ruolo">
            <label for="ruolo">Si</label>
        <input type="submit" value="Conferma" />
    </form>

    <!-- stampa la tabella con la possiblità di modificare ed eliminare un singolo campo -->
    <h3>Tabella</h3>
    <table border="1">

        <tr>
            <th>nome</th>
            <th>ruolo</th>
            <th></th>
            <th></th>
        </tr>

        <?php
            include "$GLOBALS[connessione_db]";

            $sql = "SELECT * FROM utente";

            $result = $conn->query($sql);

            while ($row=$result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["nome"]."</td>";
                if($row['ruolo'] == 1) echo "<td>".'<img width="20px" height="20px" src="../../../Images/Verde.png"></img>'."</td>";
                if($row['ruolo'] == 0) echo "<td>".'<img width="20px" height="20px" src="../../../Images/Rosso.png"></img>'."</td>";
                echo "<td>" . '<form onsubmit="return confirm('."'Sei sicuro/a di cancellare la riga?'".');" action="../delete_row.php" method="POST">
                                    <input type="hidden" value="'.$row['ID'].'" name="ID"/>
                                    <input type="hidden" value="utente" name="tabella"/>
                                    <button type="submit">
                                        <img width="24px" height="24px" src="../../../Images/delete.png"></img>
                                    </button>
                                </form>' . "</td>";
                echo "<td>" . '<form action="modifica_Account_form.php" method="POST">
                                    <input type="hidden" value="'.$row['ID'].'" name="ID"/>
                                    <input type="hidden" value="'.$row['nome'].'" name="nome"/>
                                    <input type="hidden" value="'.$row['ruolo'].'" name="ruolo"/>
                                    <button type="submit">
                                        <img width="24px" height="24px" src="../../../Images/edit.png"></img>
                                    </button>
                                </form>' . "</td>";
                echo "</tr>";
            }

            $result->free();
            $conn->close();
        ?>

    </table>

</body>
</html>