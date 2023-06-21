<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup | 404</title>
    <link rel="shortcut icon" href="{{ asset('dist/Assets/favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Roboto', 'arial';

            background-color: hsl(180, 70%, 97%);
            min-height: 80vh;
        }

        .error-wrapper {
            text-align: center;
            padding-top: 3rem;
        }

        h1 {
            font-size: clamp(100px, 15vw + 10px, 400px);
            color: hsl(190, 100%, 37%);
            margin-block: 0;

        }

        p {
            line-height: 1.5;
            margin-block: .5rem 3rem;
            letter-spacing: 2px;
            color: hsl(203, 82%, 23%);
        }

        a {
            background-color: hsl(190, 100%, 37%);
            color: white;

            border-radius: 6px;
            transition: background-color 0.3s ease;
            font-size: 20px;
            letter-spacing: 1px;
            letter-spacing: 1px;
            padding: .8em 2em;
            text-decoration: none;
        }

        a:hover {
            background-color: hsl(180, 70%, 97%);
            color: hsl(190, 100%, 37%);
            border: 2px solid currentColor;
        }
    </style>
</head>

<body>
    <div class="error-wrapper">
        <h1>403!</h1>
        <p>Oops! You are unauthorized to do this action!</p>
        <a href="{{ url()->previous() }}">Go Back</a>
    </div>
</body>

</html>
