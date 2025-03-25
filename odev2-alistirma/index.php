<?php
session_start();

$questions = json_decode(file_get_contents("questions.json"), true);

if (!isset($_SESSION["score"]) || isset($_POST["restart"])) {
    $_SESSION["score"] = 0;
    $_SESSION["current_question"] = 0;
    $_SESSION["total_questions"] = count($questions);
}

if (isset($_POST["end_game"])) {
    $_SESSION["current_question"] = $_SESSION["total_questions"] + 1;
    $game_state = "finished";
}

if (isset($_POST["submit"]) && isset($_POST["answer"])) {
    $current_question = $questions[$_SESSION["current_question"]];

    $user_answer = strtolower(trim($_POST["answer"]));

    $correct_answers = array_map("strtolower", $current_question["answer"]);

    if (in_array($user_answer, $correct_answers)) {
        $_SESSION["score"]++;
        $feedback = "Correct!";
        $feedback_class = "correct";
    } else {
        $feedback = "Wrong! Correct answer(s): " . implode(" or ", $current_question["answer"]);
        $feedback_class = "wrong";
    }

    $_SESSION["current_question"]++;
}

$game_state = "playing";
if ($_SESSION["current_question"] > $_SESSION["total_questions"]) {
    $game_state = "finished";
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Quiz Game</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
            background-color: #1a1a1a;
            color: #e0e0e0;
            line-height: 1.6;
        }

        h1 {
            color: #fff;
            font-size: 2.5em;
            margin-bottom: 1.5em;
            font-weight: 600;
        }

        .correct {
            color: #4ade80;
            padding: 10px 0;
        }

        .wrong {
            color: #f87171;
            padding: 10px 0;
        }

        .question {
            background-color: #252525;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .score {
            font-size: 1.2em;
            margin-bottom: 30px;
            color: #fff;
        }

        input[type="text"] {
            padding: 12px 16px;
            font-size: 1em;
            background-color: #333;
            border: 1px solid #444;
            border-radius: 6px;
            color: #fff;
            margin-right: 10px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #666;
        }

        button {
            padding: 12px 24px;
            font-size: 1em;
            cursor: pointer;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2563eb;
        }

        .end-game {
            margin-top: 20px;
        }

        .end-game button {
            background-color: #dc2626;
        }

        .end-game button:hover {
            background-color: #b91c1c;
        }

        a {
            color: #60a5fa;
            text-decoration: none;
            transition: color 0.3s ease;
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            color: #93c5fd;
        }

        .score p {
            margin-top: 15px;
            font-size: 1.1em;
            color: #9ca3af;
        }

        form {
            margin: 0;
        }
    </style>
</head>

<body>
<?php
echo "<h1>Quiz Game</h1>";
switch ($game_state) {
    case "playing":
        $current_question = $questions[$_SESSION["current_question"]]; ?>
        <div class="score">
            <span>Score: <?= $_SESSION["score"] ?></span>
        </div>

        <?php if (isset($feedback)): ?>
            <p class="<?php echo $feedback_class; ?>"><?php echo $feedback; ?></p>
        <?php endif; ?>

        <div class="question">
            <form method="post">
                <p>Question <?php echo $_SESSION["current_question"] + 1; ?>/<?= $_SESSION["total_questions"] ?>:</p>
                <p><?php echo $current_question["question"]; ?></p>
                <input type="text" name="answer" required autocomplete="off">
                <button type="submit" name="submit">Submit</button>
            </form>
            <form method="post" class="end-game">
                <button type="submit" name="end_game">End Game</button>
            </form>
        </div>
        <?php break;

    case "finished": ?>
        <div class="score">
            Final Score: <?php echo $_SESSION["score"]; ?> / <?php echo $_SESSION["total_questions"]; ?>

            <?php
            $percentage = ($_SESSION["score"] / $_SESSION["total_questions"]) * 100;

            if ($percentage >= 90) {
                echo "<p>Excellent, well done!</p>";
            } elseif ($percentage >= 70) {
                echo "<p>Good job! 👍</p>";
            } elseif ($percentage >= 50) {
                echo "<p>Not bad, but room for improvement</p>";
            } else {
                echo "<p>Keep studying!</p>";
            }
            ?>
        </div>
        <form method="post">
            <button type="submit" name="restart">Play Again</button>
        </form>
        <?php break;}
?>

<a href="/image">Click here to go to image page</a>
</body>

</html>
