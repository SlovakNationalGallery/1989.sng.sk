<!doctype html>
<html lang="{{ app()->getLocale() }}">

<script>
    const daysAvailable =
        <?php

        use App\Models\JournalEntry;

        $days = DB::table('journal_entries')
            ->selectRaw(' MIN(written_at) as start, MAX(written_at) as end')
            ->get();
        print(json_encode($days[0]));
        ?>;
</script>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vue/Laravel SSR App</title>
    <link rel="stylesheet" type="text/css" href="../css/app.css" />

</head>

<body>
    <script defer src="{{ mix('js/app.js') }}"></script>
</body>

</html>