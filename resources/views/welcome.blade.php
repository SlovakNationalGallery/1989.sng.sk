<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>1989 - 2019</title>
    <link rel="stylesheet" type="text/css" href="../css/app.css">
    <script src="../js/app.js"></script> 
    <style>
        @import url('https://fonts.googleapis.com/css?family=Sedgwick+Ave|Sriracha&display=swap&subset=latin-ext');

        body {
            background: url('../images/podchod.jpg') fixed;
            background-size: cover;
            text-align: center;
            background-position: top center;
            font-family: sans-serif;
            font-size: 14pt;
            padding-top: 40vh;
        }

        h1,
        h2,
        h3 {
            font-family: 'Sriracha', 'Sedgwick Ave';
        }

        h1{
            font-size: 4em;
        }
        h2{
            font-size: 3.2em;
            font-weight: normal;
        }

        h3{
            font-size: 2.1em;
        }

        .container {
            text-align: center;
        }

        .bck {
            background-color: white;
            margin: auto;
            max-width: 40vw;
            margin: 3rem auto;
            text-align: left;
            padding: 0.5rem 1rem;
        }

        img {
            max-width: 40vw;
            transform: translate(-1.5rem, -1.0rem);
        }

        .header *{
            text-align: center;
            margin-bottom: 1rem;
        }

        .footer {
            background: #666;
            color: white;
            margin: auto;
            width: 20em;
            padding: 1em 0 4em 0;
        }

        .subheader {
            position: relative;
            left: 50%;
            top: -2em;
            width: 30%;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="bck">
                <h1>Čas-Opis</h1>
                <h2>1989</h2>
            </div>
            <div class="subheader bck">
                Vizuálna kultúra, idey a udalosti Nežnej revolúcie, prebudenie občianskej spoločnosti a šírenie jej posolstiev.
            </div>
        </div>
        <div class="deadline bck">
            Spúšťame 11. novembra 2019
        </div>


        <div class="newsletter ">
            <div class="intro bck">
                Sledujte udalosti v reálnom čase
                Prihláste sa na odber pravidelného súhrnu udalostí prelomového obdobia, spolu s výberom tém.
            </div>

            <form class="bck" action="{{ url('../welcome.php') }}" method="post">

                <div class="form-group">
                    <label for="exampleInputEmail">Prihláste sa na newsletter</label>
                    <input type="email" name="user_email" id="exampleInputEmail" class="form-control">
                </div>
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary">Chcem byť v obraze</button>
            </form>
        </div>

        <div class="bridge">

            <div class="image bck">
                <img id="halftone" src="../images/lorincz_ludia_na_hranici.jpg" />
                <div>Jan Lorinz - Ľudia pri hranici, pochod do Hainburgu...</div>
            </div>

            <div class="image bck">
                <img src="../images/lorincz_ludia_na_hranici.jpg" />
                <div>Juraj Bartoš - Uličné plagáty v Bratislave</div>
            </div>
        </div>

        <div class="schools bck">
            <h3>Pre školy</h3>
            V októbri zverejníme prvý zo série článkov pre študentov, ktoré na príklade tém Novembra 89 priblížia princípy, vznik a šírenie konšpiračných teórií.
        </div>

        <div class="footer">
            Pripravuje <a href="http://www.sng.sk">Slovenská národná galéria</a>
            <div class="icons">
                <a href="http://www.sng.sk" title="Slovenská národná galéria"></a>
                <a href="http://lab.sng.sk" title="lab.sng"></a>
            </div>
        </div>
    </div>
</body>

<script>

  var testImage = document.getElementById('halftone');
 convert(testImage,'test'); 


</script>
</html>