<!-- hello hiiii hiiii <3 -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hesap Makinesi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }

        input[type="text"], input[type="submit"] {
            font-size: 20px;
            padding: 10px;
            width: 200px;
            margin: 5px;
        }

        input[type="submit"] {
            width: 100px;
        }

        #reset {
            font-size: 15px;
            padding: 5px;
            width: 100px;
            margin: 5px;
        }

        .button-container {
            margin-top: 20px;
        }
    </style>

    <script>
        function resetForm() {
            // Reload the page without POST data
            window.location.href = window.location.pathname;
        }
    </script>
</head>
<body>
    <h1>Hesap Makinesi</h1>
    <form method="POST" id="calculator">
        <input type="text" name="num1" placeholder="İlk numarayı girin" value="<?= $_POST["num1"] ?? "" ?>">
        <input type="text" name="num2" placeholder="İkinci numarayı girin" value="<?= $_POST["num2"] ?? "" ?>">
        <div class="button-container">
            <input type="submit" name="operation" value="+">
            <input type="submit" name="operation" value="-">
            <input type="submit" name="operation" value="x">
            <input type="submit" name="operation" value="/">
        </div>
        <button type="reset" id="reset" onclick="resetForm()">Resetle</button>
    </form>

    <h2>Sonuç:</h2>
    <p id="result">
        <?php
        # This placeholder is here because my formatter bugged out
        $placeholder = "";
        if (isset($_POST["operation"])) {
            $num1 = $_POST["num1"];
            $num2 = $_POST["num2"];

            # Return early if numbers aren't numeric
            if (!is_numeric($num1) || !is_numeric($num2)) {
                echo "Please enter a valid number.";
            }

            $operation = $_POST["operation"];

            switch ($operation) {
                case "+":
                    echo $num1 + $num2;
                    break;
                case "-":
                    echo $num1 - $num2;
                    break;
                # Should've probably put `*` instead of `x` but oh well.
                case "x":
                    echo $num1 * $num2;
                    break;
                case "/":
                    echo $num2 == 0 ? "0 İle bölemezsin." : $num1 / $num2;
                    break;
            }
        }
        ?></p>
</body>
</html>
