

<?php
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php");
            exit();
        }
        $fullname = htmlspecialchars($_SESSION['fullname']);
    ?>
    
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.0/js/dataTables.min.js"></script>
    <script src="http://localhost/Projects/EDP_Prefinals/js/fetch_users.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <title>Dashboard</title>
</head>
<body>
    <style>
        body {
            height: 100vh;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background: radial-gradient(circle, #1b2838, #171a21);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            font-family: sans-serif;    
            color: white;
            user-select: none;
            overflow-y: auto;
        }

        body::-webkit-scrollbar {
        display: none;
        }

        body nav
        {
            width: 100%;
            height: 90px;
            background-color: #060a13;
            display: flex;
            justify-content: center;
            align-items: center;
            box-sizing: border-box;
        }

        nav #company-name
        {
            width: 15%;
            height: 50%;
            font-size: 30px;
            font-weight: bold;
            display: flex;
            justify-content: flex-start;
            padding: 0 0 0 45px;
            align-items: center;
            border-right: 1px solid whitesmoke;
        }

        nav #user-section
        {
            width: 40%;
            height: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 0 0 0 30px;
            box-sizing: border-box;
        }
        nav #user-section i
        {
            font-size: 30px;
            margin-right: 20px;
        }
        nav #user-section p
        {
            font-size: 19px;
            
        }

        nav #logout-section
        {
            flex-grow: 1;
            height: 100%;
            font-size: 30px;
            display: flex;
            padding: 0 50px 0 0;
            justify-content: flex-end;
            align-items: center;

        }

        nav #logout-section button
        {
            border: none;
            background-color: transparent;
            color: white;
            font-size: 17px;
        }

        nav #logout-section button:hover
        {
            color: #0c66ed;
        }

        main
        {
            flex-grow: 1;
            width: 100%;
            display: flex;
            box-sizing: border-box;
        }

        #side-panel
        {
            width: 300px;
            height: 95%;
            background-color: #1b2838;
            display: flex;
            flex-direction: column;
            border-radius: 0 10px 10px 0;
            align-self: center;
            padding: 20px 0 0 0;
            box-sizing: border-box;
        }

        #side-panel span
        {
            display: flex;
            align-items: center;
            padding: 0 0 0 30px;
            box-sizing: border-box;
            transition: ease-in-out 0.25s
        }

        #side-panel i
        {
            font-size: 25px;
        }

        #side-panel p
        {
            padding: 0 0 0 20px;
        }

        #main-content
        {
            position: relative;
            z-index: 1;
            flex-grow: 1;
            height: 95%;
            align-self: center;
            box-sizing: border-box;
            margin: 0 0 0 10px;
            padding: 0 0 0 30px;
            display: flex;
            flex-direction: column;
        }

        #main-content header
        {
            display: flex;
            gap: 20px;
        }

        #main-content header .cards
        {
            width: 400px;
            height: 180px;
            display: flex;
            flex-direction: column;
            border-radius: 7px;
            background-color: #171a21;
            box-sizing: border-box;
            margin: 0 0 30px 0;
        }

        .cards .body
        {
            height: 70%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            padding: 20px 0 0 30px;
            box-sizing: border-box;
        }

        .cards .body i
        {
            font-size: 50px;
            margin: 0 20px 0 0;
        }

        .cards .body p
        {
            font-size: 60px;
        }

        .cards .subheading
        {
            display: flex;
            justify-content: flex-start;
            padding: 0 0 0 35px;
        }

        #main-content nav
        {
            background-color: transparent;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        #main-content input[type="search"]
        {
            background-color: whitesmoke;
            height: 2.6rem;
            width: 80%;
            border-radius: 7px;
            outline: none;
            border: none;
            padding: 0 0 0 20px;
            color: #060a13;
        }
        #main-content nav button {
        font-family: Arial, Helvetica, sans-serif;
        font-weight: bold;
        color: white;
        background-color: #171717;
        padding: 1em 2em;
        border: none;
        border-radius: .6rem;
        position: relative;
        cursor: pointer;
        overflow: hidden;
        margin: 0 0 0 20px;
        width: 120px;
        }

        #main-content nav button span:not(:nth-child(6)) {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        height: 30px;
        width: 30px;
        background-color: #0c66ed;
        border-radius: 50%;
        transition: .6s ease;
        }

        #main-content nav button span:nth-child(6) {
        position: relative;
        }

        #main-content nav button span:nth-child(1) {
        transform: translate(-3.3em, -4em);
        }

        #main-content nav button span:nth-child(2) {
        transform: translate(-6em, 1.3em);
        }

        #main-content nav button span:nth-child(3) {
        transform: translate(-.2em, 1.8em);
        }

        #main-content nav button span:nth-child(4) {
        transform: translate(3.5em, 1.4em);
        }

        #main-content nav button span:nth-child(5) {
        transform: translate(3.5em, -3.8em);
        }

        #main-content nav button:hover span:not(:nth-child(6)) {
        transform: translate(-50%, -50%) scale(4);
        transition: 1.5s ease;
        }

        .table
        {
            width: 90%;
            height: 500px;
        }

        .display
        {
            width: 100%;
            height: 100%;
            border-radius: 7px;
            color: #060a13;
            background-color: whitesmoke;
        }

        .display thead
        {
            height: 10%;
        }

        th, td {
            border-right: 1px solid #ccc;
        }
        th:last-child, td:last-child {
            border-right: none;
        }

        .cards, #side-panel span, #main-content nav button, input[type="search"] {
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .cards:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
        }

        #side-panel span:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #0c66ed;
            padding-left: 26px;
        }

        #main-content input[type="search"]:focus {
            width: 85%;
            box-shadow: 0 0 10px rgba(12,102,237,0.6);
        }

        #main-content nav button:hover {
            transform: scale(1.05);
        }

        #main-content nav button span.text {
            transition: 0.3s ease;
        }
        #main-content nav button:hover span.text {
            color: #0c66ed;
        }

        .display tbody tr:hover {
            background-color: rgba(12, 102, 237, 0.1);
        }

        .display thead th {
            background-color: #0c66ed33;
            transition: background-color 0.3s ease;
        }
        .display thead th:hover {
            background-color: #0c66ed77;
            color: white;
        }


        .analysis
        {
            position: absolute;
            width: 90%;
            height: 90%;
            background-color: transparent;
            margin: 20px 0 0 0;
            border-radius: 7px;
            box-sizing: border-box;
            z-index: 2;
            display: none;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 10px; 
            grid-template-areas:
                "chart1 chart2"
                "chart3 chart2";
            padding: 20px;
        }
        
        .analysis .container:nth-child(1) {
            grid-area: chart1;
        }

        .analysis .container:nth-child(2) {
            grid-area: chart2;
        }

        .analysis .container:nth-child(3) {
            grid-area: chart3;
        }

        .analysis canvas {
            padding: 20px;
            border-radius: 10px;
            background-color: #171a21;
            box-shadow: 0 5px 15px rgba(0,0,0,0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .cards .body p:hover {
            text-shadow: 0 0 10px #0c66ed;
        }

        .cards {
            perspective: 1000px;
        }
        .cards .body {
            transform-style: preserve-3d;
            transition: transform 0.6s;
        }
        .cards:hover .body {
            transform: rotateY(0deg);
        }
    </style>
    <nav>
        <div id="company-name">Deviate</div>
        <div id="user-section">
            <i class="fa-solid fa-circle-user"></i>
            <p><?php echo $fullname; ?></p>
        </div>

        <div id="logout-section">
            <span>
                <button onclick="location.href='http://localhost/Projects/EDP_Prefinals/php/index.php'">
                    log out
                </button>
            </span>
        </div>
    </nav>
    <main>
        <div id="side-panel">
            <span>
                <i class="fa-solid fa-gauge"></i>
                <p>Dashboard</p>
            </span>
            <span>
                <i class="fa-solid fa-chart-simple"></i>
                <p>Analysis</p>
            </span>
        </div>
        <div id="main-content">
            <header>
                <div class="cards" id="total-user">
                    <div class="body">
                        <i class="fa-solid fa-chart-line"></i>
                        <p>0</p>
                    </div>
                    <div class="subheading">
                        <p>Total registered users</p>
                    </div>
                </div>
            </header>

            <nav>
                <input type="search" name="search" id="search" placeholder="search users...">
                <button>
                    <span class="circle1"></span>
                    <span class="circle2"></span>
                    <span class="circle3"></span>
                    <span class="circle4"></span>
                    <span class="circle5"></span>
                    <span class="text">Search</span>
                </button>
            </nav>

            <!--data table-->
        <div class="table">
            <table id="usersTable" class="display">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>City</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!--Chart.js-->
        <div class="analysis">

            <div class=container>
                <h3>Total Registrations per Day</h3>
                <canvas id="dailyRegistrationChart" width="400" height="200"></canvas>
            </div>

            <div class=container>
                <h3>Users by Gender</h3>
                <canvas id="genderChart" width="400" height="200"></canvas>
            </div>

            <div class=container>
                <canvas id="cityChart" width="400" height="200"></canvas>
                <h3>Users by City</h3>
            </div>
        </div>


    </main>

    <script>
        $(document).ready(function() {
            loadUsersTable();
            renderDailyRegistrationChart();
        });

        let sidePanel = document.getElementById('side-panel');
        let analysisPanel = document.querySelector('.analysis');
        let cards = document.getElementById('total-user');
        let nav = document.querySelector('#main-content nav');
        let dataTable = document.querySelector('.table');

        sidePanel.children[1].addEventListener('click', () => {
            analysisPanel.style.display = 'grid';
            cards.style.display = 'none';
            nav.style.display = 'none';
            dataTable.style.display = 'none';
        });

        sidePanel.children[0].addEventListener('click', () => {
            analysisPanel.style.display = 'none';
            cards.style.display = 'block';
            nav.style.display = 'block';
            dataTable.style.display = 'block';
        });

    </script>

</body>
</html>