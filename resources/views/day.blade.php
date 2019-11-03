@extends('layouts.master')

@section('title', trans('intro.title'))

@push('styles')
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

    .journal-entry-tag {
        font-weight: bold;
        cursor: pointer;
    }
</style>
@endpush

@section('content')

<div id="app">
    <div id="calendar">
        <calendar :start="daysAvailable.start" :start-at="startAt" :end="daysAvailable.end" :day-callback="dayClbck"></calendar>
        <transition-group name="fade" tag="div">
            <div v-for="entry in content" v-bind:key="entry.written_at" class="entry-item">
                <div class="weather" v-if="entry.weather" v-html="entry.weather"></div>
                <div class="content" v-html="entry.content_for_frontpage"></div>
                <a :href="'{{route('journal-entries.show', ':date:')}}'.replace(':date:', entry.written_at)">Read whole entry</a>
            </div>
        </transition-group>
    </div>
</div>
@include('components.letters_expositions')
@include('components.footer')

@stop

@push('scripts')
<script defer>
    const calendar = new Vue({
        el: '#calendar',
        data: {
            daysAvailable: {!!$daysAvailable ?? '{}'!!},
            startAt: '{{ $date }}',
            content: {!!$entries ?? '{}'!!},
        },
        methods: {
            // wannabe vue-router replacement for now
            dayClbck: function($day) {
                this.startAt = $day;
                axios.get("{{route('api.journal-entries.show',[':day:'])}}".replace(':day:', $day))
                    .then((res) => {
                        window.history.replaceState({
                            day: $day
                        }, $day, $day);
                        this.content = (res.data);
                    });
            }
        },
        mounted: function() {
            $('body').popover({
                container: 'body',
                placement: 'bottom',
                html: true,
                content: function() {
                    const tag = $(this).data('tag');
                    const categories = $(this).data('tag-categories').split(',');
                    const route = "{{route('journal-entries.show', ['journalEntry' => $date, 'filter' => 'TAG_PLACEHOLDER'] )}}"
                        .replace('TAG_PLACEHOLDER', tag);
                    return `<strong>${tag}</strong><br /><span>Kategórie: ${categories.join(', ')}</span><br /><a href="${route}">Preskúmať heslo</a>`;
                },
                title: '',
                selector: '.journal-entry-tag'
            })
        }
    })
</script>
@endpush
