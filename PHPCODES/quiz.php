<?php
session_start();

// Define questions and answers
$questions = [
    [
        "question" => "What does PHP stand for?",
        "options" => [
            "Personal Home Page",
            "Private Home Page",
            "PHP: Hypertext Preprocessor",
            "Hypertext Preprocessor"
        ],
        "answer" => 2 // index of the correct answer
    ],
    [
        "question" => "Which of the following is a valid variable name in PHP?",
        "options" => [
            "$var_name",
            "var-name",
            "1stVariable",
            "var name"
        ],
        "answer" => 0
    ],
    [
        "question" => "Which function is used to include a file in PHP?",
        "options" => [
            "include()",
            "require()",
            "require_once()",
            "All of the above"
        ],
        "answer" => 3
    ],
    [
        "question" => "What is the correct way to start a session in PHP?",
        "options" => [
            "session_start();",
            "start_session();",
            "begin_session();",
            "session();"
        ],
        "answer" => 0
    ],
    [
        "question" => "Which operator is used for string concatenation in PHP?",
        "options" => [
            ".",
            "+",
            "&",
            "|"
        ],
        "answer" => 0
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userAnswers = $_POST['answers'];
    $score = 0;

    foreach ($userAnswers as $index => $answer) {
        if ($answer == $questions[$index]['answer']) {
            $score++;
        }
    }

    $_SESSION['score'] = $score;
    $_SESSION['totalQuestions'] = count($questions);
    $_SESSION['userAnswers'] = $userAnswers;
    $_SESSION['questions'] = $questions;
    header('Location: quiz.php');
    exit();
}

if (isset($_SESSION['score'])) {
    // Show results
    $score = $_SESSION['score'];
    $totalQuestions = $_SESSION['totalQuestions'];
    $userAnswers = $_SESSION['userAnswers'];
    $questions = $_SESSION['questions'];

    // Clear session data
    session_unset();
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <style>
        body {
            background-color: black;
            color: cyan;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            text-align: center;
            padding: 20px;
            box-shadow: 0 0 10px cyan;
        }
        .question {
            margin-bottom: 20px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quiz Result</h1>
        <h2>Your Score: <?php echo $score; ?> / <?php echo $totalQuestions; ?></h2>
        <h3>Correct Answers:</h3>
        <?php foreach ($questions as $index => $question): ?>
            <div class="question">
                <h4><?php echo ($index + 1) . ". " . $question['question']; ?></h4>
                <p>Your Answer: <?php echo $question['options'][$userAnswers[$index]]; ?></p>
                <p>Correct Answer: <?php echo $question['options'][$question['answer']]; ?></p>
            </div>
        <?php endforeach; ?>
        <a href="quiz.php">Try Again</a>
    </div>
</body>
</html>
<?php
} else {
    // Show quiz
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodePrep Quiz</title>
    <style>
        body {
            background-color: black;
            color: cyan;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            text-align: center;
            padding: 20px;
            box-shadow: 0 0 10px cyan;
        }
 .question {
            margin-bottom: 20px;
            text-align: left;
        }
        .options {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Online Quiz</h1>
        <form method="POST">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                    <h3><?php echo ($index + 1) . ". " . $question['question']; ?></h3>
                    <div class="options">
                        <?php foreach ($question['options'] as $optionIndex => $option): ?>
                            <label>
                                <input type="radio" name="answers[<?php echo $index; ?>]" value="<?php echo $optionIndex; ?>" required>
                                <?php echo $option; ?>
                            </label><br>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit">Submit Answers</button>
        </form>
    </div>
</body>
</html>
<?php
}
?>