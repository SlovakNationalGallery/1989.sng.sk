<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vue/Laravel SSR App</title>
    <link rel="stylesheet" type="text/css" href="../css/app.css" />
</head>

<body>
    <div id="calendar">

        <calendar :start="daysAvailable.start" :start-at="startAt" :end="daysAvailable.end" :day-callback="dayClbck"></calendar>

        <div v-for="entry in content">
            <div class="weather" v-if="entry.weather" v-html="entry.weather"> </div>
            <div class="content" v-html="entry.content_raw"> </div>
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        const calendar = new Vue({
            el: '#calendar',
            delimiters: ['{[', ']}'],
            data: {
                daysAvailable: <?php print($daysAvailable ?? '') ?>,
                startAt: '<?php print($date ?? '') ?>',
                content: <?php print($entries ?? '') ?>,
            },
            methods: {
                dayClbck: function($day) {
                    this.startAt = $day;
                    axios.get("../daySource/" + $day).then((res) => {
                        window.history.replaceState({
                            day: $day
                        }, $day, $day);
                        this.content = res.data;
                    });
                }
            }
        })
    </script>
</body>

</html>

<style>
    .content>p {
        display: inline;
    }

    .content br {
        display: none;
    }

    .weather {
        margin: 2em;
    }
</style>