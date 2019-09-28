<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="TODO">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/app.css" />


</head>

<body>
    <div id="apdp" class="flex-center position-ref full-height">
        <div class="content" id="calendar">
            <calendar :start="'1989-10-01'" :start-at="startAt" :end="'1990-01-01'" :day-callback="meow" ></calendar>
        </div>
    </div>
</body>

</html>
<script src="./js/app.js"></script>
<script>
    var calendar = new Vue({
        el: '#calendar',
        data: function() {
            return {
                startAt: '1989-10-01',
                meow($col) {
                    this.startAt = $col;
                }
            }
        },
    })
</script>