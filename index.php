<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Project Phase One</title>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <header>
            <h1>Network and Connection</h1>
            <nav>
                <ul>
                    <li>
                        <a>Sign Up</a>
                    </li>
                    <li>
                        <a>Login</a>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            <form action="" method="post">
                <label for="name">Name:</label>
                <input name="name" id="name" type="text" required>
                <label for="email">Email:</label>
                <input name="email" id="email" type="email" required>
                <label for="location">City:</label>
                <input name="location" id="location" type="text" required>
                <label for="skills">
                <button type="button" onclick="addFields()">Add more</button>
                <input name="skills" id="skills" type="text" required>
            <form>
        </main>
        <footer>
        </footer>
    </body>
</html>