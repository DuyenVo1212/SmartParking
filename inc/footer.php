<footer>
    <style>
    footer {
        background-color: #343a40;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    p {
        color: white;
    }

    .logo {
        flex-basis: 150px;
        margin-right: 20px;
    }

    .logo img {
        max-width: 100%;
    }

    .footer-links {
        display: flex;
        flex-wrap: wrap;
        font-weight: bolder;
    }

    .footer-links a {
        color: white;
        text-decoration: none;
        margin-right: 20px;
    }

    .footer-links a:hover {
        text-decoration: underline;
    }

    @media screen and (max-width: 480px) {
        .footer-links {
            margin-top: 10px;
        }

        .footer-links a {
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .logo {
            margin-bottom: 10px;
        }
    }

    @media screen and (max-width: 768px) {
        .logo {
            margin-right: 0;
            margin-bottom: 10px;
            flex-basis: 100%;
        }

        .footer-links {
            justify-content: center;
        }
    }

    @media screen and (max-width: 1024px) {
        footer {
            padding: 10px;
        }
    }

    @media screen and (max-width: 1280px) {
        .footer-links a {
            margin-right: 15px;
        }
    }

    @media screen and (min-width: 1281px) {
        .footer-links a:last-child {
            margin-right: 0;
        }
    }

    @media screen and (max-width: 992px) {
        .logo img {
            max-width: 150px;
        }
    }

    .hotline {
        margin-right: 0;
        margin-top: 10px;
    }

    .hotline a {
        display: flex;
        align-items: center;
        color: white;
        text-decoration: none;
        font-weight: bold;



    }

    .hotline a:hover {
        text-decoration: underline;
        /* color: #1abc9c; */
        color: #1abc9c;
    }

    .hotline img {
        max-width: 70px;
        margin-right: 10px;
        /*  background-color: transparent; */


    }

    .hotline {
        padding: 10px;
        border-radius: 5px;
        margin-right: 0;
        margin-top: 5px;
    }
    </style>

    <div class="hotline">
        <a href="tel:18001234"><img src="src/phone-icon.gif" alt="Phone icon"> Hotline: 1800 1234</a>
    </div>

    <div class="footer-links">
        <a href="#">About Us</a>
        <a href="#">Privacy Policies</a>
        <a href="#">FAQs</a>
    </div>

    <div class="copyright">
        <p>&copy; 2023 Car Park Booking</p>
        <p><strong>Designed by:</strong> Vi Van Dam - Vo Chuc Duyen</p>
    </div>

</footer>