<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vue/Laravel SSR App</title>
    <link rel="stylesheet" type="text/css" href="../css/app.css" />
    <script src="../js/vendor.js"></script>
    <script src="../js/app.js"></script>
</head>

<body>
    <div id="app">
        <div id="calendar">
            <calendar :start="daysAvailable.start" :start-at="startAt" :end="daysAvailable.end" :day-callback="dayClbck"></calendar>
            <transition-group name="fade" tag="div">
                <div v-for="entry in content" v-bind:key="entry.id" class="entry-item">
                    <div class="weather" v-if="entry.weather" v-html="entry.weather"> </div>
                    <div class="content" v-html="entry.content_raw"> </div>
                </div>
            </transition-group>
        </div>
    </div>
</body>
<script defer>
    const calendar = new Vue({
        el: '#calendar',
        data: {
            daysAvailable: <?php print($daysAvailable ?? '') ?>,
            startAt: '<?php print($date ?? '') ?>',
            content: <?php print($entries ?? '') ?>,
        },
        methods: {
            // wannabe vue-router replacement for now
            dayClbck: function($day) {
                this.startAt = $day;
                axios.get("../api/day/" + $day).then((res) => {
                    window.history.replaceState({
                        day: $day
                    }, $day, $day);
                    this.content = (res.data);
                });
            }
        }
    })
</script>

</html>

<style>
    .fade-enter-active,
    .fade-leave-active {
        opacity: 1;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }

    .entry-item {
        display: block;
        position: absolute;
        transition: all .3s ease-in-out;
    }

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